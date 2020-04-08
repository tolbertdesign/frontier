<template>
  <p>
    Para: Familias de la Clase
    <br>Cuando: Dia de equipo uno
    <br>Tema: ¡Ayuda nuestra clase!
    <br><br>{{ props.event_name }} Familias,
    <br><br>¡Nuestra clase se esta divirtiendo con preparación para el <strong>{{ props.event_name }}</strong>
    que viene pronto! También hemos comenzado a aprender cómo elegir vivir con un buen carácter todo los días a
    través de los ensenajes del nuevo tema de Booster: Mindspark Wild West. Ellos van acompañar al equipo
    de MindSpark para completar duelos de carácter, sus estudiantes aprenderán cinco rasgos de carácter
    del siglo XXI que ayudarán a fortalecerse a sí mismos y a nuestro mundo. ¡Aseguerse de preguntarles a
    sus estudiantes de lo que han estado aprendiendo cada día, y juntos pueden ver cómo se desarrolla
    la historia en <a :href="`https://${props.link}`">{{ props.link }}</a>!
    <br><br>Recuerde, necesitamos su ayuda para conectarse con los patrocinadores que puede hacer una donación
    para ayudar nuestra escuela! Asegurese de que todas las donaciones para el
    <strong>{{ props.event_name }}</strong> están en <a :href="`https://${props.link}`">{{ props.link }}</a>.
    Cuántas mas donaciones que recibimos, más incentivos podemos obtener en la clase en nuestro Pledge-O-Meter.
    <br><br>Muchas gracias por su generosidad y apoyo para ayudar nuestra escuela. Si usted tiene preguntas, por favor déjeme saber.
    <br><br>¡Que tenga un buen día!
    <br><br>PD: Asegurese de registrar su estudiante en <a :href="`https://${props.link}`">{{ props.link }}</a>.
    Utilice nuestro código de registro escolar: <strong>{{ props.registration_code }}.</strong><br>
  </p>
</template>

<script>
export default {
  name: 'TeamDay',
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
