import { MapAdapter } from "../components/ui/map_adapter";

document.addEventListener('DOMContentLoaded', () => {
    const googleMaps = document.querySelectorAll('.maps--google');

    googleMaps.forEach((googleMap) => {
        const mapAdapter = new MapAdapter(googleMap);

        mapAdapter.googleMap();
    });
})