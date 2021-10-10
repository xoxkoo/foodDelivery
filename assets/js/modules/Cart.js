export default class Cart {

    constructor() {
        this.items = []
        this.quantity = 0

        this.box = document.querySelector('.cart-box')
    }

    update(e) {
        e.preventDefault()
        const form = e.target
        const item = e.target.closest('.item')

        const params = this.serialize(form)

        axios({
            method: 'post',
            url: form.action,
            data: params
        }).then((response) => {

            if (response.data !== 'error') {
                this.items = response.data

                this.getQuantity(response.data)

                document.querySelectorAll('.cart-items').forEach(item => item.dataset.items = this.quantity)

                // reset animation
                if (item.classList.contains('add-an')) {
                    item.classList.remove('add-an')
                    item.offsetWidth
                }

                if ( !item.classList.contains('cart-item') && !item.classList.contains('product')) item.classList.add('add-an')

                this.showBox()

            }

        })

    }

    serialize(form) {

        const params = new URLSearchParams()

        form.querySelectorAll('input').forEach(input => {
            if (input.name !== 'toppings[]') {
                params.append(input.name, input.value)
            }
            else {
                if (input.checked === true || input.autocompleted === true || input.type === 'hidden')
                    params.append(input.name, input.value)
            }
        })

        return params
    }

    getQuantity(items) {
        this.items = items
        this.quantity = 0

        for ( const [id, quantity] of Object.entries(this.items) ) {
            this.quantity += +quantity
        }

        this.updateQuantity()

    }

    updateQuantity() {
        document.querySelector('.cart-items-box').dataset.items = this.quantity

        if (this.quantity === 0)
            document.querySelector('.cart-items-box').style.display = 'none'
        else
            document.querySelector('.cart-items-box').style.display = 'flex'

    }

    hideItem(e) {
        let hidden = 0
        const item = e.target.closest('.item')
        const items = document.querySelectorAll('.item')

        item.classList.add('fadeOut')

        items.forEach(item => {
            if (item.classList.contains('fadeOut')) hidden++
        })

        if (hidden === items.length) {
            setTimeout(() => {
                window.location.reload('false')
            }, 500)
        }

    }

    checkElements() {
        const items = document.querySelectorAll('.item')

        for ( const [id, quantity] of Object.entries(this.items) ) {
            items.forEach(item => {
                const element = item.id.split('_')[1]

                if (id !== element) {
                    item.classList.add('fadeOut')
                }

            })
        }
    }

    showBox() {
        this.box.classList.remove('hidden', 'added')
        this.box.style.display = 'flex'
        this.box.querySelector('.content').innerHTML = 'Váš košík bol aktualizovaný!'
        this.box.querySelector('.cross-icon').style.display = 'flex'
        this.box.querySelector('.cart-items').style.display = 'none'
        this.box.classList.remove('cart-box-sm')
        this.box.classList.add('added')

        setTimeout(this.minimizeBox, 7500)
    }

    minimizeBox() {
        // this.box = document.querySelector('.cart-box')

        console.log(this.box)

        if (! this.box.classList.contains('cart-box-sm')) {
            this.box.querySelector('.content').innerHTML = 'Košík'
            this.box.querySelector('.cross-icon').style.display = 'none'
            this.box.querySelector('.cart-items').style.display = 'block'

            let box = this.box

            setTimeout(function () {
                box.classList.add('cart-box-sm')
            }, 200)
        }
    }

}