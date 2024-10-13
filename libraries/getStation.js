document.addEventListener('DOMContentLoaded', function() {
    const areaSelect = document.getElementById('area');
    
    areaSelect.addEventListener('change', function() {
        //console.clear();
        var valorSeleccionado = this.value;
        //console.log(valorSeleccionado);

        if (valorSeleccionado !== '0') {
            fetchStations(valorSeleccionado);
        } else {
            document.getElementById('machineFields').innerHTML = ''; // Clear previous content
        }
    });

    function fetchStations(id_area) {
        // Make a request to get_stations.php with the selected id_area
        fetch(`../includes/get_stations.php?id_area=${id_area}`)
            .then(response => response.json())
            .then(data => addMachineFields(data))
            .catch(error => console.error('Error al obtener los datos:', error));
    }

    function addMachineFields(stations) {
        const machineFieldsDiv = document.getElementById('machineFields');
        machineFieldsDiv.innerHTML = ''; // Clear previous content

        // Create label for Machine
        const label = document.createElement('label');
        label.setAttribute('for', 'machine');
        label.className = 'form-label';
        label.textContent = 'Machine';

        // Create select element for Machine
        const select = document.createElement('select');
        select.name = 'machine';
        select.id = 'machine';
        select.className = 'form-select';
        select.setAttribute('aria-label', 'Default select example');

        // Create and append 'ALL' option
        const allOption = document.createElement('option');
        allOption.value = '0';
        allOption.textContent = 'ALL';
        select.appendChild(allOption);

        // Add options from the stations data
        stations.forEach(station => {
            const option = document.createElement('option');
            option.value = station.id_station;
            option.textContent = station.nm_station;
            select.appendChild(option);
        });

        // Append label and select to the machineFields div
        machineFieldsDiv.appendChild(label);
        machineFieldsDiv.appendChild(select);
    }
});