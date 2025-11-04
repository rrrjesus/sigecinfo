<?php

namespace Source\Support;

use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

/**
 * Class QrCode
 * @package Source\Support
 */
class QrCode
{
    /**
     * @param string $content
     * @return string
     */
    public function svg(string $content): string
    {
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new SvgImageBackEnd()
        );
        $writer = new Writer($renderer);
        return $writer->writeString($content);
    }
}