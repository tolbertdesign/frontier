<template>
  <p>
    Para: Familias de escuela
    <br>
    Cuando: Dia antes del evento
    <br>Tema: ¡El {{ props.event_name }} es manana!
    <br><br>
    <strong>{{ props.event_name }}</strong> Familias,
    <br><br>
    ¡El <strong>{{ props.event_name }}</strong> es mañana!
    Gracias a todas nuestras familias que han estado trabajando arduamente para recaudar fondos para nuestra escuela.
    Nosotros verdaderamente apreciamos su apoyo.
    <br><br>Solo queda un día del programa. Eso quiere decir que esta noche es LA ULTIMA NOCHE PARA DONACIONES antes del <strong>{{ props.event_name }}</strong>
    <br><br><strong>¿Considerarías hablar a uno o dos patrocinadores más esta noche?</strong>
    <br><br>Si tiene alguna pregunta, por favor hágamelo saber. Esperamos verlos a usted y a su familia mañana en el GRAN evento.
    <br><br>¡Tenga un dia maravilloso!<br>
  </p>
</template>

<script>
export default {
  name: 'DayBeforeFunrun',
  status: 'prototype',
  release: '1.0.0',
  props: {
    props: {
      type: Object,
      default: () => {},
    },
  },
}
</script>
