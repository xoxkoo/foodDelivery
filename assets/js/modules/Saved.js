export default class Saved {

    constructor() {
        this.items = []
        this.quantity = 0
    }

    update(e, element) {
        e.preventDefault()
        const href = element.getAttribute('href')

        axios.get(href).then((response) => {
            this.items = response.data

            this.getQuantity(response.data)

            this.updateLink(element)

            if (! element.closest('.item').classList.contains('cart-item') && ! element.classList.contains('cross-icon')) {
                if (element.closest('.item').classList.contains('saved') )
                    this.remove(element)
                else
                    this.add(element)
            }
        })

    }

    add(element) {
        element.closest('.item').classList.add('saved')
        element.classList.add('heart-an')
        element.classList.remove('heart-remove-an')
    }

    remove(element) {
        element.closest('.item').classList.remove('saved')
        element.classList.add('heart-remove-an')
        element.classList.remove('heart-an')
        element.blur()
    }

    updateLink(element) {
        const id = element.closest('.item').id.split('_')[1]
        const oldLink = element.href.split('/')

        const tmp = oldLink.splice(oldLink.length - 1, 1)[0]

        // change action
        const action = (tmp.includes('remove')) ? `saved.php?add=${id}` : `saved.php?remove=${id}`

        // add action to end
        oldLink.push(action)
        element.href = oldLink.join('/')
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
        document.querySelector('.saved-items-box').dataset.items = this.quantity

        if (this.quantity === 0)
            document.querySelector('.saved-items-box').style.display = 'none'
        else
            document.querySelector('.saved-items-box').style.display = 'flex'

    }
}