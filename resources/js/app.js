import "./bootstrap";

import Alpine from "alpinejs";

window.Alpine = Alpine;

Alpine.start();

// @googlemaps/js-api-loader
import { Loader } from "@googlemaps/js-api-loader";

const loader = new Loader({
    apiKey: "AIzaSyAUF9iPbyH4nrwkZXVza__RSrSWiNOKsuo",
    version: "weekly",
    libraries: ["places"],
});

window.googleMaps = loader;
