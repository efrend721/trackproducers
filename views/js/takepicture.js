
document.addEventListener('DOMContentLoaded', function() {
  
    var worker = new Worker('../libraries/imageProcessor.js');
    var video = document.getElementById('video'),
        canvas = document.getElementById('canvas'),
        startbutton = document.getElementById('startbutton'),
        activatebutton = document.getElementById('activate'),
        icon = activatebutton.querySelector('i'),
        context = canvas.getContext('2d');
    var localMediaStream = null;
    let idJobElement = document.getElementById('idJob');
    let idUserElement = document.getElementById('idUser');
    var gallery = document.getElementById('gallery'); // Div for image gallery
    var modal = document.getElementById('modal');
    var modalImg = document.getElementById('img01');
    var captionText = document.getElementById('caption');
    var span = document.getElementsByClassName('close')[0];
    
    // Initialize the Tooltip
    var tooltipTrigger = new bootstrap.Tooltip(activatebutton);

    // Function to add image to gallery and configure modal
    function addToGallery(imageSrc) {
        var img = document.createElement('img');
        img.src = imageSrc;
        img.onclick = function() {
            modal.style.display = "block";
            modalImg.src = this.src;
            captionText.innerHTML = this.alt;
        }
        gallery.appendChild(img);
    }

    activatebutton.addEventListener('click', function(ev) {
        ev.preventDefault();
        if (!localMediaStream) {
            navigator.mediaDevices.getUserMedia({ 
              video: {
                      facingMode: {
                      exact: 'environment'
                  }
              },
              audio: false 
            })
                .then(function(stream) {
                    video.srcObject = stream;
                    video.play();
                    localMediaStream = stream;
                    icon.className = 'bi bi-camera-video-off';
                    activatebutton.setAttribute('data-bs-original-title', 'Deactivate Camera');
                    tooltipTrigger.hide().show();
                })
                .catch(function(err) {
                    console.error('Error accessing the camera:', err);
                });
        } else {
            if (video.srcObject) {
                video.srcObject.getTracks().forEach(track => track.stop());
                video.srcObject = null;
            }
            localMediaStream = null;
            icon.className = 'bi bi-camera-video';
            activatebutton.setAttribute('data-bs-original-title', 'Activate Camera');
            tooltipTrigger.hide().show();
            video.pause();
            context.clearRect(0, 0, canvas.width, canvas.height);
        }
    }, false);

    startbutton.addEventListener('click', function(ev) {
        ev.preventDefault();
        if (localMediaStream) {
            takepicture(worker);
        } else {
            console.log('Error: The camera is not activated.');
        }
    }, false);

    function takepicture(worker) {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        var imageDataUrl = canvas.toDataURL('image/jpeg', 1.0);
        // Add the image to the gallery for preview
        addToGallery(imageDataUrl);

        // Send the image to the worker for processing
        worker.postMessage({cmd: 'processImage', imageDataUrl: imageDataUrl});

        worker.onmessage = function(e) {
            var processedImageDataUrl = e.data.imageDataUrl;
            console.log('Processed Image URL:', processedImageDataUrl);

            // Here you could send the processed image to the server or do something with it
            fetch('../includes/saveimage.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ image: processedImageDataUrl, idUser: idUserElement.textContent, idJob: idJobElement.textContent })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
            })
            .catch(error => {
                console.error('Error sending the image:', error);
            });
        };
    }
});