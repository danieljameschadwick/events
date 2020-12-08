export default class GoogleMap {
    /**
     * @param {Element} element
     * @param {decimal} longitude
     * @param {decimal} latitude
     * @param {?string} title
     */
    constructor(
        element,
        longitude,
        latitude,
        title = null
    ) {
        this.element = element;
        this.longitude = longitude;
        this.latitude = latitude;
        this.title = title;

        this.infoWindow = null;
        this.latLng = null;
    }

    init() {
        this.latLng = {
            lat: Number.parseFloat(this.latitude),
            lng: Number.parseFloat(this.longitude)
        };

        this.map = new google.maps.Map(this.element, {
            center: this.latLng,
            zoom: 8,
        });

        this.setMarker();
    }

    setMarker() {
        const contentString = `<div class="google-maps--info-window">
            <div class="content">
                ${this.title}
            </div>
        </div>`;

        this.infoWindow = new google.maps.InfoWindow({
            content: contentString
        });

        this.marker = new google.maps.Marker({
            position: this.latLng,
            map: this.map,
            title: this.title,
        });

        this.marker.setMap(this.map);

        this.marker.addListener('click', () => {
            this.infoWindow.open(this.map, this.marker);
        });
    }
}