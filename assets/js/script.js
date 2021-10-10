import Quantity from "./modules/Quantity.js"
import Cart from "./modules/Cart.js"
import Input from "./modules/Input.js"
import Saved from "./modules/Saved.js"

const inputClass = new Input()
const cart = new Cart()
const saved = new Saved()

inputClass.focus()
cart.getQuantity(getCart())
saved.getQuantity(getSaved())

if (document.querySelector('.btn-add')) {

    document.querySelectorAll('.btn-add').forEach(btn => btn.addEventListener('click', (e) => {

        const id = e.target.dataset.id
        const item = document.getElementById(`item_${id}`)

        const input = item.querySelector('input[name=quantity_input]')
        const input_real = item.querySelector('input[name=quantity]')

        const quantity = new Quantity(input, input_real)

        if (e.target.dataset.sign === 'plus') {
            quantity.plus()
        }
        else {
            quantity.minus()
        }
    }))

}


/**
 * add to cart
 */
document.querySelectorAll('.cart-update').forEach(form => form.addEventListener('submit', (e) => {

    cart.update(e)

}))

/**
 * add to saved
 */
document.querySelectorAll('.saved-update').forEach(icon => icon.addEventListener('click', function (e) {

    saved.update(e, this)

}))

/**
 * hide item when click on cross
 */
document.querySelectorAll('.hide-item').forEach(cross => cross.addEventListener('click', (e) => {

    cart.hideItem(e)

}))

/**
 * show, hide menu
 */
const menu = document.querySelector('.menu')
document.querySelector('.menu-icon-wrap').addEventListener('click', (e) => {
    menu.classList.toggle('open')
})

if (document.querySelector('.hide-flash')) {
    document.querySelector('.hide-flash').addEventListener('click', (e) => {
        e.preventDefault()
        hideFlash()
    })

}

// setTimeout( function () {
//     if (document.querySelector('.alert')) {
//         hideFlash()
//     }
// }, 7500)

function hideFlash() {
    const item = document.querySelector('.alert')

    cart.minimizeBox()
    // if (item.classList.contains('cart-box')) {
    //     cart.minimizeBox()
    // }
    // else {
    //     item.classList.remove('added')
    //     item.classList.add('hidden')
    // }
    // item.classList.remove('added')
    // item.classList.add('hidden')
}

/**
 * categories stuff
 */
const categories = document.querySelectorAll('.category')
categories.forEach(category => category.addEventListener('click', (e) => {
    // e.preventDefault()

    // const href = e.target.getAttribute('href')
    //
    // axios.get(href).then((response) => {
    //     const html = document.createElement('html')
    //     html.innerHTML = response.data
    //
    //     const container = document.querySelector('.items-container')
    //     const itemsOld = Array.from( container.children )
    //     const itemsNew = Array.from( html.querySelector('.items-container').children )
    //
    //     itemsOld.map(item => item.classList.add('fadeOut'))
    //
    //     itemsNew.forEach(item => {
    //         item.classList.add('fadeIn')
    //         container.appendChild(item)
    //     })
    //
    // })
}))

/**
 * order input stuff
 */
if (document.querySelector('.order')) {

    document.getElementById('phone').addEventListener('input', (e) => {
        inputClass.validatePhone(e)
    })

    let timeout;

    document.querySelector('.order').querySelectorAll('.input').forEach((input) => {

        ['keydown', 'focusout', 'onautocomplete'].forEach((event) => {

            input.addEventListener(event, (e) => {

                if (e.type === 'keydown') {
                    // if (e.key === 'Enter')
                    //     e.preventDefault()
                    if(timeout) {
                        clearTimeout(timeout);
                        timeout = null;
                    }

                    timeout = setTimeout(function() {
                        if (e.target === document.activeElement)
                            inputClass.validateInput(e.target)
                    }, 1500)
                }
                else if (e.target.id !== 'note')
                    inputClass.validateInput(e.target)

            })

        })

        document.addEventListener('load', (e) => {
            inputClass.validateInput(e.target)
        })
    })


}

