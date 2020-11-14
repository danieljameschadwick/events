const dayjs = require('dayjs');

window.dayjs = dayjs;

document.addEventListener('DOMContentLoaded', () => {
    window.calendar = new App();

    const calendar = window.calendar;
    calendar.fetch();

    console.log(calendar.data);
});

const MONTH_NAMES = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
const DAYS = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];

class App {
    fetch() {
        window.fetch('/api/calendar')
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                this.data = data;
            })
            .catch((error) => {
                console.log('error');
            })
        ;
    }
}