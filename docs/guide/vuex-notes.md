```js
activePrograms: state => {
    return state.User.programs.filter(program => {
        return program.archived === 0 && program.deleted === 0;
    });
},
teacherPrograms: (state, getters) => {
    let programs = [];
    return getters.activePrograms.forEach(program => {
        program.participants.forEach(participant => {
            if (participant.id === state.User.teacher_participant_id) {
                programs.push(program);
            }
        });
    });
    return programs;
}
```

## Parent Dashboard
```js
import { mapGetters } from 'vue'
export default {
    computed: {
        ...mapGetters(['programs'])
    }
}
```

## Loader

```js
export default {
    created () {
        this.$store.dispatch('initStore', this.user)
        this.$store.commit('SET_S3_BUCKET', this.s3_bucket)
        this.$store.commit('SET_AVATAR_PATH', this.avatar_path)
        this.$store.commit('SET_LANG', this.lang)
    }
}
```
