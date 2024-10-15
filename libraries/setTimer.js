class ProyectoCronometro {
    constructor(idProyecto, fechaFormateada, lTime) {
        this.idProyecto = idProyecto;
        this.fechaHoraRegistro = fechaFormateada;
        this.lTime = lTime;
        this.lTimeMilisegundos = this.lTime * 60 * 1000; // Asumiendo que lTime está en minutos
        this.diferenciaMilisegundos = 0;
        this.funcionYaEjecutada = false;
        
        this.elemento = document.getElementById(`cronometro${this.idProyecto}`);
        this.elemento1 = document.getElementById(`miDivId${this.idProyecto}`);
    }

    formatearFecha(fecha) {
        let ano = fecha.getFullYear();
        let mes = fecha.getMonth() + 1; // getMonth() es base 0
        let dia = fecha.getDate();
        let hora = fecha.getHours();
        let minuto = fecha.getMinutes();
        let segundo = fecha.getSeconds();

        mes = (mes < 10 ? '0' : '') + mes;
        dia = (dia < 10 ? '0' : '') + dia;
        hora = (hora < 10 ? '0' : '') + hora;
        minuto = (minuto < 10 ? '0' : '') + minuto;
        segundo = (segundo < 10 ? '0' : '') + segundo;

        return `${ano}-${mes}-${dia} ${hora}:${minuto}:${segundo}`;
    }

    convertirAFechaObjeto(cadenaFecha) {
        
        let partesFecha = cadenaFecha.split(' ');
        let partesDia = partesFecha[0].split('-');
        let partesHora = partesFecha[1].split(':');
        return new Date(partesDia[0], partesDia[1] - 1, partesDia[2], partesHora[0], partesHora[1], partesHora[2]);
    }

    actualizarCronometro() {
        let fechaInicio = this.convertirAFechaObjeto(this.fechaHoraRegistro);
        let ahora = new Date();
        let fechaFormateada = this.formatearFecha(ahora);
        let fechaActual = this.convertirAFechaObjeto(fechaFormateada);
        this.diferenciaMilisegundos = fechaActual - fechaInicio;
        let segundosTotales = Math.floor(this.diferenciaMilisegundos / 1000);
        let dias = Math.floor(segundosTotales / 86400);
        let horas = Math.floor((segundosTotales - (dias * 86400)) / 3600);
        let minutos = Math.floor((segundosTotales - (dias * 86400) - (horas * 3600)) / 60);
        let segundos = segundosTotales - (dias * 86400) - (horas * 3600) - (minutos * 60);

        horas = (horas < 10 ? '0' : '') + horas;
        minutos = (minutos < 10 ? '0' : '') + minutos;
        segundos = (segundos < 10 ? '0' : '') + segundos;

        let textoCronometro = `${dias} days, ${horas}:${minutos}:${segundos}`;
        this.elemento.innerText = textoCronometro;

        if (this.diferenciaMilisegundos > this.lTimeMilisegundos ) {
            this.actualizarEstiloElemento();
            
        }
    }

    actualizarEstiloElemento() {
        
        if (this.elemento) {
            this.elemento.style.color = 'red';
        }
    }
    
    alterarContenidoDiv() {
        if (this.funcionYaEjecutada) {
            return; // Sale de la función si ya se ejecutó
        }
        // Verifica si se encontró el elemento
        if (this.diferenciaMilisegundos > this.lTimeMilisegundos ) {
                                  
            if (this.elemento1) {
                this.elemento1.getAttribute('class')
                if (this.elemento1.getAttribute('class') != null){
                    this.elemento1.removeAttribute('class');
                }
                var elementoPadre = this.elemento1.parentNode;
                // Obtener el ícono por su clase
                var icono = elementoPadre.getElementsByClassName('bi-check-circle-fill')[0];
                // Eliminar el ícono
                if (icono){
                icono.remove();
                }
                

                this.elemento1.setAttribute('class', 'row alert alert-warning alert-dismissible');
                var icono = document.createElement("i");
                icono.classList.add("bi", "bi-exclamation-triangle-fill");
                icono.textContent = " Delayed.";
                this.elemento1.appendChild(icono);
                this.funcionYaEjecutada = true;
        
            } else {
                console.error("No se encontró el elemento con el id 'miDivId'.");
            }
            
            
        }
        else{
                        
            if (this.elemento1) {
                this.elemento1.getAttribute('class')
                if (this.elemento1.getAttribute('class') != null){
                    this.elemento1.removeAttribute('class');
                }
                var elementoPadre = this.elemento1.parentNode;
                // Obtener el ícono por su clase
                var icono = elementoPadre.getElementsByClassName('bi-check-circle-fill')[0];
                // Eliminar el ícono
                if (icono){
                icono.remove();
                }
                  

                this.elemento1.classList.add("row", "alert", "alert-success", "alert-dismissible");
                var icono = document.createElement("i");
                icono.classList.add("bi", "bi-check-circle-fill");
                icono.textContent = " On Time.";
                this.elemento1.appendChild(icono);
            } else {
                console.error("No se encontró el elemento con el id 'miDivId'.");
            }

        }
        
    }
}

// Uso de la clase
// Suponiendo que tienes los valores para idProyecto, fechaFormateada, y lTime
// Asegúrate de reemplazar 'idProyecto', 'fechaFormateada', y 'lTime' con valores reales al crear la instancia
let cronometroProyecto = new ProyectoCronometro('idProyecto', 'fechaFormateada', 'lTime');
cronometroProyecto.actualizarCronometro();
cronometroProyecto.alterarContenidoDiv();


