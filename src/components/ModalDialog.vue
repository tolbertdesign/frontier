import ModalDialog from '@/components/ModalDialog';
<template>
  <div ref="modalDialog" class="modal-dialog">
    <header>
      Modal Dialog
    </header>
    <main>
      <slot>
        Default Modal Slot
      </slot>
    </main>
    <footer class="flex items-center justify-center">
      <button>Save</button>
      <button>Cancel</button>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'ModalDialog',
  data () {
    return {
      // open: false,
      resolve: null,
      // isConfirmationDialogVisible doesn't really
      // belong with the place of use of the dialog.
      // It should be an internal implementation detail
      // of the dialog itself.
      isConfirmationDialogVisible: false,
    }
  },
  methods: {
    open () {
      console.log('Modal open')
    },
    close () {
      console.log('ModalDialog close')
    },
    async show () {
      return new Promise(resolve => {
        this.resolve = resolve
        this.open = true
      })
    },
    onOkButtonClick () {
      this.open = false
      this.resolve && this.resolve('ok')
    },
    onCancelButtonClick () {
      this.open = false
      this.resolve && this.resolve('cancel')
    },

    showConfirmationDialog () {
      this.isConfirmationDialogVisible = true
    },
    hideConfirmationDialog () {
      this.isConfirmationDialogVisible = false
    },
    handleConfirm () {
      this.hideConfirmationDialog()
      // the dialog ended with "OK" - perform some action
    },
    handleCancel () {
      this.hideConfirmationDialog()
      // the dialog ended with "Cancel" - do nothing
    },
  },
}
</script>

<style lang="postcss">
  h1[rel="handsome"][title^="Important"] { color: red; }
  h1[rel|="friend"] { color: red; }
  h1[rel~="external"] { color: red; }/* require spaces around attr */
  h1[rel*="external"] { color: red } /* does not */
  h1[rel^="external"] { color: red; }
  [ref="modalDialog"] { color: red }
  input[type="text"] { color: red }
  input[type="radio"] { color: red }
  [id*="post"]  { color: red; }
  a[href*="boosterthon.com"] { color: red; }
  a[href$=".pdf"] {
    background: url(/img/icon-pdf.png) left center no-repeat;
    padding-left: 30px;
  }
  a[href$=".doc"] {
    background: url(/img/icon-doc.png) left center no-repeat;
    padding-left: 30px;
  }
</style>
