<?php
    class FlightSearch {
        protected $optional_arguments = 'data-colour="lunar" data-origin-iata-code="BER" data-destination-iata-code="BJL" data-flight-type="return" data-flight-outbound-date="2024-01-03" data-flight-inbound-date="2024-02-23"';
        public function sky_scaner_widget(){
            echo '
            <div data-skyscanner-widget="SearchWidget" '.$this->optional_arguments.'  >
            </div>
            <script src="https://widgets.skyscanner.net/widget-server/js/loader.js" async>
            </script>
            ';
        }
    }
?>