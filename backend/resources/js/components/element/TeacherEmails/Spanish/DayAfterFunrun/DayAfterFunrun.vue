<template>
  <p>
    Para: Familias de Escuela
    <br>
    Cuando: Dia después del evento
    <br>Tema: Gracias por su apoyo!
    <br><br>
    <strong>{{ props.event_name }}</strong> Familias,
    <br><br>
    ¡Muchas gracias por apoyar el <strong>{{ props.event_name }}</strong> de este año!
    El programa fue un gran éxito, y sé que todos se divirtieron mucho.
    Solo queda una cosa más por hacer.
    <br><br>
    Necesitamos su ayuda para reunir todas nuestras donaciones.
    Como clase, recaudamos <strong>${{ props.class_pledge_total }}</strong> - nuestro objetivo es recaudar el 100% de todas las donaciones a más tardar en la <strong>{{ props.due_date }}</strong>.
    <br><br>Todos los patrocinadores que incluyeron su dirección de correo electrónico al hacer una donación recibirán un recordatorio por correo electrónico y instrucciones para pagar su donación.
    Comuníquese con los patrocinadores que NO incluyeron su dirección de correo electrónico para informarles que pueden enviarle dinero en efectivo o cheque, que luego se enviará a la escuela en el sobre de la colección de su hijo (pronto volverá a casa).
    <br><br>Finalmente, ¡anime a su estudiante a agradecer a todos sus patrocinadores por ayudar a nuestra escuela!
    <br><br>¡Gracias de nuevo por tu ayuda! Déjeme saber si tienes alguna pregunta.<br>
  </p>
</template>

<script>
export default {
  name: 'DayAfterFunrun',
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
