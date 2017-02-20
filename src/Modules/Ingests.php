<?php

namespace IBurn36360\TwitchInterface\Modules;

use \IBurn36360\TwitchInterface as InterfaceBase;

class Ingests
    extends ModuleBase {
    public function runGetIngestServers($parameters, InterfaceBase\Configuration $configuration, InterfaceBase\HTTPClient $client = null) {
        if (is_null($client)) {
            $client = new InterfaceBase\HTTPClient($configuration->twitchAPIHost);
        }
    }
}
