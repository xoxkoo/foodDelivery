export default class Quantity {

    constructor(input, input_real) {
        this.input = input
        this.input_real = input_real

        this.min = parseInt(input.min)
        this.max = parseInt(input.max)
    }

    plus() {
        if (this.input.value < this.max) {
            this.input.value++
            this.load()
        }
    }

    minus() {
        if (this.min < this.input.value) {
            this.input.value--
            this.load()
        }
    }

    load() {
        this.input_real.value = this.input.value
    }
}