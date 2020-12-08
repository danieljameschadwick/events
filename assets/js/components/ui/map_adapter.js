import GoogleMap from "./google_map";

export class MapAdapter {
    /**
     * @param {Element} element
     */
    constructor(element) {
        this.element = element;
        this.latitude = this.element.dataset.latitude;
        this.longitude = this.element.dataset.longitude;
        this.title = this.element.dataset.title;

        this.instances = [];
    }

    googleMap() {
        const googleMap = new GoogleMap(
            this.element,
            this.longitude,
            this.latitude,
            this.title
        );

        googleMap.init();

        this.instances.push(googleMap);
    }
}