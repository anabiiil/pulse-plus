<template>
    <div class="text-end my-4">
        <button type="button" class="btn btn-info me-2 btn-b"  @click.prevent="updateComponent">Create Admin</button>
    </div>

    <!-- Page Header Close -->
<!--    <admin-table></admin-table>-->

</template>
<script>


import eventBus from "../../../../main/event-bus.ts";
import {useHead} from "@vueuse/head";


export default {
    setup() {
        useHead({
            title: 'Show Onboarding',
        });
    },
    data: () => ({
    }),

    methods: {
        updateComponent(){
            eventBus.emit('admin-event', { message: 'Data from AdminTable' });
            this.create = true;
        },
        handleEvent(payload) {
            // Call the showAction method with the action from the event payload
            // this.showAction(payload.action);
        },
    },
    mounted() {
        // Listen for the event when the component is mounted
        eventBus.on('set-show-action', this.handleEvent);
    },
    beforeUnmount() {
        // Clean up the event listener when the component is destroyed
        eventBus.off('set-show-action', this.handleEvent);
    },
}
</script>
