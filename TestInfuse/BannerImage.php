<?php

namespace TestInfuse;

class BannerImage
{
    protected $fileName;
    protected $fileSize;
    protected $mimeType;

    public function __construct($fileName, $fileSize = null, $mimeType = null)
    {
        $this->fileName = $fileName;
        $this->fileSize = $fileSize ?? filesize($this->fileName);
        $this->mimeType = $mimeType ?? mime_content_type($this->fileName);
    }

    /**
     * Send an banner image as HTTP response.
     */
    public function response()
    {
        $fp = fopen($this->fileName, 'rb');

        header("Content-Type: " . $this->mimeType);
        header("Content-Length: " . $this->fileSize);

        fpassthru($fp);
    }
}