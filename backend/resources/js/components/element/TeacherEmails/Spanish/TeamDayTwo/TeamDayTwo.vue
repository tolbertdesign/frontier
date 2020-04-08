<template>
  <p>
    Para: Familias de Clase
    <br>Cuando: cualquier día de equipo (repetir como sea necesario)
    <br>Tema: ¡Mira nuestro progresso!
    <br><br>
    <strong>{{ props.event_name }}</strong> Familias,
    <br><br>¡Nuestra clase esta aprendiendo con diversion en cómo tener un buen carácter todo los días!
    ¡Aseguerse en consultar con su estudiante hoy y pregunte qué están aprendiendo con Mindspark: Wild West!
    <br><br>¡Quiero darles un actualización sobre cómo estamos progresando! Nuestra clase ha llegado a
    <strong>${{ props.class_pledge_total }}</strong> en nuestro Pledge-O-Meter. Nosotros creemos que podemos avanzar
    más para ayudar nuestra escuela!
    <br><br>¿Nos ayudará a contactar a uno o dos patrocinadores más esta noche?
    <br><br>Si aun no ha registrado su estudiante en <a :href="`https://${props.link}`">{{ props.link }}</a>
    no se preocupe, todavía hay mucho tiempo para hacerlo. Ademas, una vez que su estudiante esté registrado,
    encontrará muchas formas fáciles y divertidas de comunicarse con los patrocinadores a través de nuestro
    Easy Emailer, Facebook Share Button, ¡o incluso el Video de Student Star!
    <br><br>¡Muchas gracias por su apoyo por la escuela!
    <br><br>Déjeme saber si tiene preguntas.
    <br><br><strong>PD: La forma MÁS FÁCIL de solicitar donaciones es simplemente haciendo clic en el botón
      "Compartir en Facebook" en la página de donaciones de su estudiante.
      En promedio, compartir la pagina para donar en Facebook aumenta las donaciones totales en casi
      $50 con un solo clic.</strong>
  </p>
</template>

<script>
export default {
  name: 'TeamDayTwo',
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
