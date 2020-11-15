import React from 'react';
import ReactDOM from 'react-dom';
import Calendar from '../components/calendar/calendar';

document.addEventListener('DOMContentLoaded', () => {
    const calendar = document.querySelector('#calendar');

    ReactDOM.render(<Calendar />, calendar);
});