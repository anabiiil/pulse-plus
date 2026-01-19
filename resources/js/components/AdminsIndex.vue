<template>
    <div class="text-start my-4" v-if="!actions.showList">
        <button type="button" class="btn btn-secondary me-2 btn-b" @click.prevent="showAction('list')">
            <i class="las la-arrow-alt-circle-left"></i>
            Back
        </button>
    </div>
    <router-view></router-view>

    <div class="text-end my-4" v-if="actions.showList">
        <router-link to="createAdmin">Home</router-link>
        <button type="button" class="btn btn-info me-2 btn-b" @click.prevent="showAction('create')">
            Create Admin
        </button>
    </div>

    <!-- Page Header Close -->
<!--    <admin-table v-if="actions.showList"></admin-table>-->
<!--    <create-admin v-if="actions.showCreate"></create-admin>-->
<!--    <update-admin v-if="actions.showUpdate"></update-admin>-->
<!--    <delete-admin v-if="actions.showDelete"></delete-admin>-->

</template>
<script>




export default {
    data: () => ({
        actions: {
            showCreate: false,
            showUpdate: false,
            showDelete: false,
            showList: true,
        },
    }),
    methods: {
        handleEvent(payload) {
            // Call the showAction method with the action from the event payload
            this.showAction(payload.action);
        },
        showAction(action) {
            // Reset all actions to false
            for (let key in this.actions) {
                if (this.actions.hasOwnProperty(key)) {
                    this.actions[key] = false;
                }
            }
            // Set the specific action to true dynamically
            this.actions[`show${action.charAt(0).toUpperCase() + action.slice(1)}`] = true;
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
