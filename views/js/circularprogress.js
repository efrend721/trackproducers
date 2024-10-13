class CustomProgressBar {
  constructor(containerId, progress) {
    
    this.bar = new ProgressBar.Circle(containerId, {
      strokeWidth: 6,
      trailWidth: 6,
      easing: 'easeInOut',
      duration: 1400,
      color: '#FFEA82',
      trailColor: '#eee',
      from: { color: '#FFEA82', width: 6 },
      to: { color: '#ED6A5A', width: 6 },
      step: function(state, circle) {
        circle.path.setAttribute('stroke', state.color);
        circle.path.setAttribute('stroke-width', state.width);

        var value = Math.round(circle.value() * 100);
        circle.setText(value + '%');
      },
      text: {
        autoStyleContainer: false
      }
    });

    // Inicialización inmediata con el valor de progreso.
    this.animate(progress);
  }
  

  animate(progress) {
    // Asegúrate de que el progreso está entre 0.0 y 1.0
    const safeProgress = Math.min(1, Math.max(0, progress));
    this.bar.animate(safeProgress); // Valor de 0.0 a 1.0, donde 1.0 es 100%
  }
}

  
  