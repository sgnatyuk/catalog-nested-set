<template>
    <div :class="['modal', { 'is-active': active }]">
        <div class="modal-background"></div>

        <div class="modal-card">

            <header class="modal-card-head">
                <p class="modal-card-title">{{ title }}</p>
                <button class="delete" aria-label="close" @click="active = false"></button>
            </header>

            <section class="modal-card-body">
                <slot></slot>
            </section>

            <footer class="modal-card-foot">
                <button class="button is-success" @click="save">Save</button>
                <button class="button" @click="active = false">Cancel</button>
            </footer>
        </div>

    </div>
</template>

<script>
    export default {
        props: {
            title: String,
            value: Boolean,
        },
        computed: {
            active: {
                get() {
                    return this.value
                },
                set(state) {
                    this.$emit('input', state)
                },
            },
        },
        methods: {
            save() {
                this.$emit('save')
            },
        },
    }
</script>