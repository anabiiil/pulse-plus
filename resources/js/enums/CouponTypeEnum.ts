// CouponTypeEnum.ts

export const CouponTypeEnum = {
    PERCENTAGE: {
        label: 'Percentage',
        class: 'bg-info',
        value: 'percentage',
    },
    FIXED: {
        label: 'Fixed Amount',
        class: 'bg-primary',
        value: 'fixed',
    },

    getLabel(type: string) {
        return type === this.PERCENTAGE.value ? this.PERCENTAGE.label : this.FIXED.label;
    },
    getClass(type: string) {
        return type === this.PERCENTAGE.value ? this.PERCENTAGE.class : this.FIXED.class;
    },
    isPercentage(type: string) {
        return type === this.PERCENTAGE.value;
    },
};
