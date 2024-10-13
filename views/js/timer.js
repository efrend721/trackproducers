//let $fecha_start = document.getElementById('fecha_start').value;
//let $hora_start = document.getElementById('hora_start').value;
let fecha_start = '2021-07-04';
let hora_start = '12:00:00';

const fechaHoraRegistro = fecha_start + 'T' + hora_start;

            function iniciarCronometro(fechaHoraRegistro) {
                // Convertir fecha y hora de registro a objeto Date de JavaScript
                const fechaInicio = new Date(fechaHoraRegistro); // Usa el valor combinado de fecha y hora

                const ahora = new Date();
                
                // Calcular la diferencia en milisegundos entre la fecha de registro y ahora
                const diferenciaInicial = ahora.getTime() - fechaInicio.getTime();

                // Iniciar el cronómetro con esta diferencia
                actualizarCronometro(diferenciaInicial);
            }

            function actualizarCronometro(diferenciaInicial) {
                // Obtener la diferencia actualizada sumando la diferencia inicial
                const ahora = new Date().getTime();
                const distancia = ahora - diferenciaInicial;
                
                // Calcula horas, minutos y segundos
                let horas = Math.floor((distancia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                let minutos = Math.floor((distancia % (1000 * 60 * 60)) / (1000 * 60));
                let segundos = Math.floor((distancia % (1000 * 60)) / 1000);
                
                // Añade un cero adelante si es necesario
                horas = (horas < 10) ? 0 + horas : horas;
                minutos = (minutos < 10) ? 0 + minutos : minutos;
                segundos = (segundos < 10) ? 0 + segundos : segundos;

                document.getElementById('cronos').innerHTML = horas + ':' + minutos + ':' + segundos;

                // Volver a llamar a actualizarCronometro cada segundo
                setTimeout(() => actualizarCronometro(diferenciaInicial), 1000);
            }

            // Iniciar el cronómetro al cargar la página
            window.onload = function() {
                iniciarCronometro(fechaHoraRegistro);
            };