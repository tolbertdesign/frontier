<template>
  <div
    :id="'carouselComponent'+id"
    class="carousel-component carousel slide"
  >
    <!-- main slider carousel items -->
    <div class="carousel-inner">
      <div
        class="active item carousel-item"
        data-slide-number="0"
      >
        <div style="position:relative; padding-bottom:56.25%; overflow:hidden;"><iframe
          src="https://content.jwplatform.com/players/2MZ3klOL-JcxcCN5H.html"
          width="100%"
          height="100%"
          frameborder="0"
          scrolling="auto"
          allowfullscreen
          style="position:absolute;"
        /></div>
      </div>
      <div
        class="item carousel-item"
        data-slide-number="1"
      >
        <img
          style="width:100%;"
          src="https://i0.wp.com/www.adelaideexplorer.com/wp-content/uploads/2018/01/thalassa-playground-3.jpg?fit=1920%2C1080&ssl=1"
          alt=""
        >
      </div>
      <div
        class="item carousel-item"
        data-slide-number="2"
      >
        <img
          style="width:100%;"
          src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/EQMOWcXPx/carousel-spins-on-the-playground_b3l-yctd__F0000.png"
          alt=""
        >
      </div>
      <div
        class="item carousel-item"
        data-slide-number="3"
      >
        <img
          style="width:100%;"
          src="http://p.motionelements.com/stock-video/lifestyle-recreation/me8346334-aerial-view-kids-playground-hd-a0199.jpg"
          alt=""
        >
      </div>
      <div
        class="item carousel-item"
        data-slide-number="4"
      >
        <img
          style="width:100%;"
          src="http://cms.hugofox.com//resources/images/0f8ba63d-2f1a-486b-8e10-9967c3a22e65.jpg"
          alt=""
        >
      </div>
      <div
        class="item carousel-item"
        data-slide-number="5"
      >
        <img
          style="width:100%;"
          src="http://bintzaninn.com/wp-content/uploads/2017/07/playground4.jpg"
          alt=""
        >
      </div>
    </div>

    <ul class="carousel-indicators list-inline">
      <li class="list-inline-item active">
        <a
          id="carousel-selector-0"
          :data-target="'#carouselComponent'+id"
          class="selected"
          data-slide-to="0"
        >
          <img
            style="height:56px; width:100px;"
            src="http://content.jwplatform.com/thumbs/KRa4CCUp-320.jpg"
            class="img-fluid"
          >
        </a>
      </li>
      <li class="list-inline-item">
        <a
          id="carousel-selector-1"
          :data-target="'#carouselComponent'+id"
          data-slide-to="1"
        >
          <img
            style="height:56px; width:100px;"
            src="https://i0.wp.com/www.adelaideexplorer.com/wp-content/uploads/2018/01/thalassa-playground-3.jpg?fit=1920%2C1080&ssl=1"
            class="img-fluid"
          >
        </a>
      </li>
      <li class="list-inline-item">
        <a
          id="carousel-selector-2"
          :data-target="'#carouselComponent'+id"
          data-slide-to="2"
        >
          <img
            style="height:56px; width:100px;"
            src="https://d2v9y0dukr6mq2.cloudfront.net/video/thumbnail/EQMOWcXPx/carousel-spins-on-the-playground_b3l-yctd__F0000.png"
            class="img-fluid"
          >
        </a>
      </li>
      <li class="list-inline-item">
        <a
          id="carousel-selector-3"
          :data-target="'#carouselComponent'+id"
          data-slide-to="3"
        >
          <img
            style="height:56px; width:100px;"
            src="http://p.motionelements.com/stock-video/lifestyle-recreation/me8346334-aerial-view-kids-playground-hd-a0199.jpg"
            class="img-fluid"
          >
        </a>
      </li>
      <li class="list-inline-item">
        <a
          id="carousel-selector-4"
          :data-target="'#carouselComponent'+id"
          data-slide-to="4"
        >
          <img
            style="height:56px; width:100px;"
            src="http://cms.hugofox.com//resources/images/0f8ba63d-2f1a-486b-8e10-9967c3a22e65.jpg"
            class="img-fluid"
          >
        </a>
      </li>
      <li class="list-inline-item">
        <a
          id="carousel-selector-5"
          :data-target="'#carouselComponent'+id"
          data-slide-to="5"
        >
          <img
            style="height:56px; width:100px;"
            src="http://bintzaninn.com/wp-content/uploads/2017/07/playground4.jpg"
            class="img-fluid"
          >
        </a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data () {
    return {
      id: null,
    }
  },
  mounted () {
    this.id = this._uid
  },
}
</script>
