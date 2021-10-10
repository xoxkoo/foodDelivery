<?php
require_once 'vendor/autoload.php';

// Start a Session
if( !session_id() ) @session_start();

use \Tamtamchik\SimpleFlash\Flash;
use Tamtamchik\SimpleFlash\BaseTemplate;
use Tamtamchik\SimpleFlash\TemplateInterface;

class CustomTemplate extends BaseTemplate implements TemplateInterface
{
    protected $prefix  = '<p>'; // every line prefix
    protected $postfix = '</p>'; // every line postfix
    protected $wrapper = '<div class="alert alert-%s added" role="alert"> <div class="item-icon">📦</div> <div class="col"> %s </div> <div class="item-icon cross-icon hide-flash"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48"><defs></defs><title>Skryť</title><g id="Shopicon"><path d="M35.31,12.69h0A.93.93,0,0,0,34,12.6l-.09.09L24,22.59l-9.9-9.9a1,1,0,0,0-1.33-.09l-.08.09h0A.93.93,0,0,0,12.6,14l.09.09,9.9,9.9-9.9,9.9a1,1,0,0,0-.09,1.33l.09.08h0A.93.93,0,0,0,14,35.4l.09-.09,9.9-9.9,9.9,9.9a1,1,0,0,0,1.33.09l.08-.09h0A.93.93,0,0,0,35.4,34l-.09-.09L25.41,24l9.9-9.9a1,1,0,0,0,.09-1.33Z"/></g></svg></div> </div>'; // wrapper over messages of same type

    /**
     * @param $messages - message text
     * @param $type     - message type: success, info, warning, error
     *
     * @return string
     */
    public function wrapMessages($messages, $type)
    {
        return sprintf($this->getWrapper(), $type, $messages);
    }
}
flash()->setTemplate(new CustomTemplate);
