<?php

namespace n3b\Bundle\Util\HttpFoundation\StreamResponse;

use Symfony\Component\HttpFoundation\Response;

/**
 * Description of StreamResponse
 *
 * @author neb
 */
class StreamResponse extends Response
{
    public function sendContent()
    {
        $this->writer->write();
    }
    
    public function setWriter(StreamWriterInterface $obj)
    {
        $this->writer = $obj;
    }
    
    public function setContent($content)
    {
        $this->setWriter($content);
    }
}
