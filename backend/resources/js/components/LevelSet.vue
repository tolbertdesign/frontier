<template>
  <div>
    <transition name="slide-fade">
      <div
        v-if="pledge != null"
        class="level-set col-xs-12 col-md-2"
      >
        <div
          class="level-set-item col-xs-12"
        >
          🎉
          <i class="fa fa-money text-success" />
          {{ pledge.pledge_sponsor.first_name }} gave ${{ pledge.amount }}
          <i class="fa fa-money text-success" />
          🎉
          <div class="col-xs-12">
            <div class="offset-lg-4 text-center mx-auto mb-3 mt-3">
              <a
                :href="special_url"
                class="btn btn-lg btn-round btn-success w-100 mw-200px"
              >Give Now!</a>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  props: {
    special_url: {
      type: String,
      default: null,
    },
    program_id: {
      type: Number,
      default: null,
    },
  },
  data () {
    return {
      pledge: null,
      pledges: [],
      offset: 0,
    }
  },
  watch: {
    pledges: (val) => {
      if (val.length < 3) {
        this.getPledges()
      }
    },
  },
  created () {
    this.getPledges()
  },
  methods: {
    startLevelSet () {
      this.setPledge()
    },
    setPledge () {
      setTimeout(() => {
        this.pledge = this.pledges.pop()
        this.removePledge()
      }, this.randomIntFromInterval(2500, 6000))
    },
    removePledge () {
      setTimeout(() => {
        this.pledge = null
        this.setPledge()
      }, 5000)
    },
    randomIntFromInterval (min, max) { // min and max included
      return Math.floor(Math.random() * (max - min + 1) + min)
    },
    getPledges () {
      axios.get('/api/v3/public_pledges/' + this.program_id)
        .then(response => {
          this.pledges.push(...response.data.data)
          _.shuffle(this.pledges)
          this.startLevelSet()
        })
        .catch(exception => {

        })
    },
  },
}
</script>
<style>
.slide-fade-enter-active {
  transition: all .3s ease;
}
.slide-fade-leave-active {
  transition: all .8s cubic-bezier(1.0, 0.5, 0.8, 1.0);
}
.slide-fade-enter, .slide-fade-leave-to {
  transform: translateY(30px);
  opacity: 0;
}

</style>
<style scoped lang="scss">
.level-set{
    position:fixed;
    right:0px;
    bottom:0px;
    background: #f5f8fa;
    border: 1px solid #ccc;
    .level-set-item {
        padding:10px 5px;
        font-size:16px;
        letter-spacing: 1px;

    }

}
</style>
