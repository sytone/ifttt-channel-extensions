<?php

  require_once(dirname(__FILE__) . '/settings.php');
  require_once(dirname(__FILE__) . '/log.php');
  require_once(dirname(__FILE__) . '/recipes.php');
  require_once(dirname(__FILE__) . '/plugin.php');
  
  error_reporting(-1);
  ini_set('display_errors', 1);
  $request_body = file_get_contents('php://input');

/*$request_body = "<?xml version=\"1.0\" ?>
<?xml version="1.0" encoding="UTF-8"?>
<methodCall>
  <methodName>metaWeblog.newPost</methodName>
  <params>
    <param>
      <value>
        <string />
      </value>
    </param>
    <param>
      <value>
        <string>username</string>
      </value>
    </param>
    <param>
      <value>
        <string>password</string>
      </value>
    </param>
    <param>
      <value>
        <struct>
          <member>
            <name>title</name>
            <value>
              <string>Saldohälytys S-Pankista</string>
            </value>
          </member>
          <member>
            <name>description</name>
            <value>
              <string>Description String</string>
            </value>
          </member>
          <member>
            <name>categories</name>
            <value>
              <array>
                <data>
                  <value>
                    <string>plugin:email</string>
                  </value>
                  <value>
                    <string>from:jouni.kaplas@iki.fi</string>
                  </value>
                </data>
              </array>
            </value>
          </member>
          <member>
            <name>mt_keywords</name>
            <value>
              <array>
                <data>
                  <value>
                    <string>IFTTT</string>
                  </value>
                  <value>
                    <string>IFTTT channel extensions</string>
                  </value>
                  <value>
                    <string>Gmail</string>
                  </value>
                </data>
              </array>
            </value>
          </member>
          <member>
            <name>post_status</name>
            <value>
              <string>publish</string>
            </value>
          </member>
        </struct>
      </value>
    </param>
    <param>
      <value>
        <boolean>1</boolean>
      </value>
    </param>
  </params>
</methodCall>";
*/
    $xml = simplexml_load_string($request_body);

    __log("Endpoint triggered");
    if($DEBUG) { __log($request_body); }

    // Plugin?
    $__PLUGIN = null;

    if (!$xml) {
        __errorAndDie("No XML Payload!");
    }

    switch ($xml->methodName) {
        //wordpress blog verification
        case 'mt.supportedMethods':
            success('metaWeblog.getRecentPosts');
            break;
    
        //first authentication request from ifttt
        case 'metaWeblog.getRecentPosts':
            //send a blank blog response
            //this also makes sure that the channel is never triggered
            success('<array><data></data></array>');
            break;
        // Process a post from ifttt andpull it apart to determine plugin and properties
        case 'metaWeblog.newPost':
            __log("Processing newpost payload");
            
            //@see http://codex.wordpress.org/XML-RPC_WordPress_API/Posts#wp.newPost
            $obj = new stdClass;
        
            //get the parameters from xml
            $obj->username = (string) $xml->params->param[1]->value->string;
            $obj->password = (string) $xml->params->param[2]->value->string;
    
            //@see content in the wordpress docs
            $content = $xml->params->param[3]->value->struct->member;
            foreach ($content as $data) {
                switch ((string) $data->name) {
    		
                    // Tags are processed as a simple array
                    case 'mt_keywords':
    		                $tags = array();
    		                foreach ($data->xpath('value/array/data/value/string') as $cat) {
                            array_push($tags, (string) $cat);
                        }
    		                $obj->tags = $tags;
    		                break;
    		
                    // Categories are parsed as object properties
                    case 'categories':
                        foreach ($data->xpath('value/array/data/value/string') as $cat) {
    			                  $parts = preg_split('/:/', (string) $cat);
    			                  if (count($parts) == 2) {
                              $obj->{$parts[0]} = $parts[1];
                            }
                        }
                        break;
    
                    // Others values are stored just as string (eg. title and description)
                    default:
                        $obj->{$data->name} = (string) $data->value->string;
                }
            }
            
            if ( select_the_right_recipe_for($obj) ) {
                success('<string>200</string>');
    	      } else {
                failure(400);
            }
            break;
    }
    
    
    
    /** POSSIBLE RESPONSES FOR IFTTT **************************************************************/
    
    function success($innerXML) {
        __log("Success!");
        $xml = "<?xml version='1.0'?><methodResponse><params><param><value>$innerXML</value></param></params></methodResponse>";
        output($xml);
    }
    
    function output($xml) {
        $length = strlen($xml);
        header('Connection: close');
        header('Content-Length: ' . $length);
        header('Content-Type: text/xml');
        header('Date: ' . date('r'));
        echo $xml;
        exit;
    }
    
    function failure($status) {
        __log("Failure: $status", 'ERROR');
        $xml = "<?xml version='1.0'?><methodResponse><fault><value><struct>";
        $xml = $xml."<member><name>faultCode</name><value><int>$status</int></value></member>";
        $xml = $xml."<member><name>faultString</name><value><string>Request was not successful.</string></value></member>";
        $xml = $xml."</struct></value></fault></methodResponse>";
        output($xml);
    }
