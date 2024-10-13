
    function sortTable(columnIndex) {
        var table = document.getElementById('projectTable');
        var rows = Array.from(table.getElementsByClassName('row'));

        rows.sort(function(a, b) {
            var cellA = a.getElementsByClassName('col-' + (columnIndex + 1))[0].innerText;
            var cellB = b.getElementsByClassName('col-' + (columnIndex + 1))[0].innerText;

            if (columnIndex === 2) { // Si es la columna de fechas
                return new Date(cellA) - new Date(cellB);
            }

            if (cellA < cellB) return -1;
            if (cellA > cellB) return 1;
            return 0;
        });

        table.innerHTML = "";
        rows.forEach(function(row) {
            table.appendChild(row);
        });
    }
