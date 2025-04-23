import './bootstrap';
import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';
import frLocale from '@fullcalendar/core/locales/fr';

// Initialisation du calendrier
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('calendar');
    if (calendarEl) {
        const calendar = new Calendar(calendarEl, {
            plugins: [dayGridPlugin, interactionPlugin],
            initialView: 'dayGridMonth',
            locale: frLocale,
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth'
            },
            events: JSON.parse(calendarEl.dataset.events),
            dateClick: function(info) {
                window.location.href = calendarEl.dataset.route + "?date=" + info.dateStr + "&view=month&filter_type=" + calendarEl.dataset.filterType;
            },
            eventClick: function(info) {
                showEventDetails(info.event.id);
            }
        });
        calendar.render();
    }
});

window.showEventDetails = function(eventId) {
    fetch(`/api/events/${eventId}`)
        .then(response => response.json())
        .then(event => {
            // Afficher les détails dans la modal
            // ...
        });
};
