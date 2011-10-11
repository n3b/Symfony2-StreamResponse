<?php

namespace n3b\Bundle\Util\HttpFoundation\StreamResponse;

/**
 * Description of StreamWriterWrapper
 *
 * @author neb
 */
class StreamWriterWrapper implements StreamWriterInterface
{
    protected $writer;
    protected $method;
    protected $stream;
    
    public function __construct($writer, $method, $stream = 'php://output')
    {
        $this->writer = $writer;
        $this->method = $method;
        $this->stream = $stream;
    }
    
    public function write()
    {
        $this->writer->{$this->method}($this->stream);
    }
}
