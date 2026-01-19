// StatusEnum.js

export const StatusEnum = {
    ACTIVE: {
        label: 'Active',
        class: 'bg-success',
        value: 1
    },
    INACTIVE: {
        label: 'Inactive',
        class: 'bg-danger',
        value: 0
    },

    // Utility functions
    getLabel(status:number) {
        return status == this.ACTIVE.value ? this.ACTIVE.label : this.INACTIVE.label;
    },
    getClass(status:number) {
        return status == this.ACTIVE.value ? this.ACTIVE.class : this.INACTIVE.class;
    }
};
