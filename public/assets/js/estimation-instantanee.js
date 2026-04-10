(function () {
  'use strict';

  const form = document.getElementById('instant-estimation-form');
  if (!form) return;

  const resultBox = document.getElementById('instant-estimation-result');
  const errorBox = document.getElementById('instant-estimation-error');

  const setError = (message) => {
    errorBox.textContent = message || 'Une erreur est survenue.';
    errorBox.style.display = 'block';
    resultBox.style.display = 'none';
  };

  const hideError = () => { errorBox.style.display = 'none'; };

  form.addEventListener('submit', async (event) => {
    event.preventDefault();
    hideError();

    const payload = {
      location: document.getElementById('ie-location')?.value || '',
      location_normalized: document.getElementById('ie-location-normalized')?.value || '',
      place_id: document.getElementById('ie-place-id')?.value || '',
      lat: document.getElementById('ie-lat')?.value || '',
      lng: document.getElementById('ie-lng')?.value || '',
      property_type: document.getElementById('ie-property-type')?.value || '',
      surface: document.getElementById('ie-surface')?.value || '',
      csrf_token: form.querySelector('input[name="csrf_token"]')?.value || '',
    };

    if (!payload.lat || !payload.lng) {
      setError('Sélectionnez une adresse proposée par Google pour fiabiliser la géolocalisation.');
      return;
    }

    try {
      const response = await fetch('/api/estimation-instantanee', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });

      const data = await response.json();
      if (!response.ok || !data.ok) {
        setError(data.message || 'Estimation indisponible pour cette zone.');
        return;
      }

      document.getElementById('result-low').textContent = new Intl.NumberFormat('fr-FR').format(data.low) + ' €';
      document.getElementById('result-med').textContent = new Intl.NumberFormat('fr-FR').format(data.median) + ' €';
      document.getElementById('result-high').textContent = new Intl.NumberFormat('fr-FR').format(data.high) + ' €';
      document.getElementById('result-comparables').textContent = String(data.comparables_count || 0);
      resultBox.style.display = 'block';
    } catch (e) {
      setError('Erreur réseau. Veuillez réessayer.');
    }
  });
})();

window.initInstantEstimationAutocomplete = function initInstantEstimationAutocomplete() {
  const input = document.getElementById('ie-location');
  if (!input || !window.google || !google.maps || !google.maps.places) return;

  const autocomplete = new google.maps.places.Autocomplete(input, {
    fields: ['place_id', 'formatted_address', 'geometry'],
    types: ['geocode'],
    componentRestrictions: { country: 'fr' },
  });

  autocomplete.addListener('place_changed', () => {
    const place = autocomplete.getPlace();
    if (!place || !place.geometry || !place.geometry.location) return;

    const lat = place.geometry.location.lat();
    const lng = place.geometry.location.lng();

    document.getElementById('ie-place-id').value = place.place_id || '';
    document.getElementById('ie-lat').value = String(lat);
    document.getElementById('ie-lng').value = String(lng);
    document.getElementById('ie-location-normalized').value = place.formatted_address || input.value;
  });
};
