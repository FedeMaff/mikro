<?php

namespace MikroTest\Assets\Classes;

use Mikro\Encrypter\RS256;

class FakeRS256Encrypter extends RS256
{
    public function __construct()
    {
        $privateKey = <<<EOF
        -----BEGIN RSA PRIVATE KEY-----
        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
        -----END RSA PRIVATE KEY-----
        EOF;

        $publicKey = <<<EOF
        -----BEGIN PUBLIC KEY-----
        MIICIjANBgkqhkiG9w0BAQEFAAOCAg8AMIICCgKCAgEAo+rOwhYUHIIOHOPr3JfZ
        wpCGtjhnhbeZZlQMcXzAE5P3NTJ5yM3Mr9cV1dVVLLsRHXobyGnfq/0hYiifHFD7
        qt0DWVlqzO/IyrMY2gVGvGi7ejpIA3/8lRXOFO6cum9gzy7tNIp47AiAM35dl6Gr
        GDK6FHiF5lNrTza2HxBEDPVWZ5GA4xJTVei/R0qD+lnXArazM9oOYWt+txSCaV1w
        QnX1eawwFxqY2BjS+gI4oy6D1U3NY+2b9gZMPMiWISam4gPNmBjF7oGMaZUQ2BEw
        eWA2xN8LSEn3Oa3ShKdyrXQhn+aqKK9QtmvxF859d1fqTP91ryEDJDT2IlMLAUk9
        9q7RrMSrpn5FcJFrRS30pCg2MyWLIUwdNVQTVBwrITUIIO8FvpGFtCq0seoRuCgh
        2/fOQdK7418qU7Ur6VCcNpQOPpYn3qfAB6Nxicfon6X0nQL+wEzAegLkVQruleau
        U+ZLbrBWIOvlMpzPmTvnk+N301oemYgwhRUkbJbUhRvrJIEJVDCu2vUMhLKYUuaL
        8xYYnL43M8mWo6hiVObZg2i+Grz5C3X3cP5pSdyRnFGAvs/hwp0rt+MOrXlp4nMZ
        iYWbpI1cAj6trFzHCGKLR7ZVw73iw8luAIJo40JbojwqGh0aNOaLQt5AL9/2mu0P
        BIvl4WyMR18UnO7QGrG5PsUCAwEAAQ==
        -----END PUBLIC KEY-----
        EOF;

        parent::__construct($privateKey, $publicKey);
    }
}
