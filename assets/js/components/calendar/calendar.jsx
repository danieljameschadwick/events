import React, {useEffect, useState} from 'react';
import FullCalendar from '@fullcalendar/react';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import Modal from 'react-modal';

Modal.setAppElement(document.querySelector('body'));

const Calendar = () => {
    const [error, setError] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);
    const [events, setEvents] = useState([]);

    const [modalIsOpen, setIsOpen] = React.useState(false);
    const [modalData, setModalData] = React.useState({});

    const customStyles = {
        content: {
            top: '50%',
            left: '50%',
            right: 'auto',
            bottom: 'auto',
            marginRight: '-50%',
            transform: 'translate(-50%, -50%)',
            zIndex: 100,
            backgroundColor: 'white'
        }
    };

    function openModal() {
        setIsOpen(true);
    }

    function afterOpenModal() {

    }

    function closeModal() {
        setIsOpen(false);
    }

    useEffect(() => {
        fetch('/api/calendar')
            .then(response => response.json())
            .then(
                (data) => {
                    setIsLoaded(true);

                    const formattedEvents = [];

                    for (const [date, events] of Object.entries(data)) {
                        for (const [key, event] of Object.entries(events)) {
                            formattedEvents.push({
                                'title': event.name,
                                'date': event.startDateTime
                            })
                        }
                    }

                    setEvents(formattedEvents);
                },
                (error) => {
                    setIsLoaded(true);
                    setError(error);
                }
            )
    }, []);

    const handleDateClick = (arg) => {
        alert(arg.dateStr);
    }

    const handleEventClick = (arg) => {
        setModalData({
            title: arg.title,
            startDateTime: arg.startDateTime
        });

        openModal();
    }

    if (error) {
        return <div>Error: {error.message}</div>;
    } else if (!isLoaded) {
        return <div>Loading...</div>;
    } else {
        return (
            <div>
                <FullCalendar
                    plugins={[dayGridPlugin, interactionPlugin]}
                    eventClick={handleEventClick}
                    initialView="dayGridMonth"
                    events={events}
                />

                <Modal
                    isOpen={modalIsOpen}
                    onAfterOpen={afterOpenModal}
                    onRequestClose={closeModal}
                    style={customStyles}
                    contentLabel="Example Modal"
                >
                    <h2>Test Modal</h2>
                    <button onClick={closeModal}>close</button>
                    <div>{ modalData.startDateTime }</div>
                </Modal>
            </div>
        )
    }
};

export default Calendar;