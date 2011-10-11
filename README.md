use it in your controllers

    <?php 
    
    use n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamResponse,
        n3b\Bundle\Util\HttpFoundation\StreamResponse\FileWriter,
        n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamWriterWrapper;

    class MyController
    {
        // just sending a file
        public function sendFileAction()
        {
            $response = new StreamResponse(new FileWriter(__DIR__ . '/../Resources/price.xls'));
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment;filename=price.xls');
        
            return $response;
        }

        // or using third-party library, that can send data direct into output stream, PhpExcel as example
        public function sendStreamAction()
        {
            $pe = new \PHPExcel();
            ...
            $writer = \PHPExcel_IOFactory::createWriter($pe, 'Excel5');

            $response = new StreamResponse(new StreamWriterWrapper($writer, 'save', 'php://output'));
            $response->headers->set('Content-Type', 'text/vnd.ms-excel; charset=utf-8');
            $response->headers->set('Content-Disposition', 'attachment;filename=stream.xls');
        
            return $response;
        }
    }

also you can use your own stream wrappers

    <?php

    use n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamResponse,
        n3b\Bundle\Util\HttpFoundation\StreamResponse\StreamWriterInterface;

    class MyWrapper implements StreamWriterInterface
    {
        protected $stream;

        public function __construct($stream)
        {
            if(!is_resource $stream)
                throw new \Exception();

            $this->stream = $stream;
        }

        public function write()
        {
            echo stream_get_contents($this->stream);
        }
    }

    class MyController
    {
        public function sendStreamAction()
        {
            $streamWrapper = new MyWrapper(fopen('http://www.example.com', 'r'));
            $response = new StreamResponse($streamWrapper);

            return $response;
        }
    }