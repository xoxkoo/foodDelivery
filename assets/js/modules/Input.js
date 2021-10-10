export default class Input {
    constructor() {
        // this.items = document.querySelectorAll('.input')
    }

    focus() {
        const inputs = Array.from(document.querySelectorAll('.input'))

        inputs.forEach((input) => {

                // input.addEventListener('focusin', (e) => {
            //     const label = document.querySelector(`label[for="${input.name}"]`)
            //
            //     if (label != null) {
            //         this.active(label)
            //
            //         // if (input.value.trim() === '')
            //         // else
            //         //     this.filled(label, input)
            //
            //     }
            // })

            // on focus in and out adding and removing class
            ['focusin', 'focusout', 'onautocomplete'].forEach((event) => {
                const label = document.querySelector(`label[for="${input.name}"]`)

                input.addEventListener(event, () => {

                    if (label != null) {

                        if (event === 'focusin') {
                            label.classList.add('label-active')
                            label.classList.remove('label-filled')
                        }

                        if (event === 'focusout') {
                            if (input.value.trim() !== '')
                                label.classList.add('label-filled')
                            else
                                label.classList.remove('label-active')

                        }

                        if (event === 'onautocomplete') {
                            label.classList.add('label-active')
                            label.classList.add('label-filled')
                        }

                        // if (input.value.trim() === '')
                        //     this.active(label)
                        // else
                        //     this.filled(label, input)

                    }

                })
            })

            // if input is not empty, move up label
            window.addEventListener('load', () => {
                const label = document.querySelector(`label[for="${input.name}"]`)

                if (document.activeElement === input) {

                    if (label && input.value === '')
                        this.active(label)
                    else
                        this.filled(label)

                }

                if (label && input.value !== '')
                    this.filled(label)

            })

        })

    }

    // validate(index) {
    //
    //     let inputs = Array.from( this.sections[index].querySelectorAll('input') )
    //     let valid = true
    //
    //     inputs.forEach(input => {
    //
    //         this.validateInput(input)
    //
    //         if ( input.parentElement.classList.contains('invalid') )
    //             valid = false
    //
    //     })
    //
    //     return valid
    //
    // }

    // in zipCode you can type only numbers
    // validateZip(e) {
    //     const isNumber = isFinite(e.key)
    //     const whitelist = ['Backspace','Delete','ArrowDown','ArrowUp','ArrowRight','ArrowLeft']
    //     const whitelistKey = whitelist.includes(e.key)
    //
    //     if (!isNumber && !whitelistKey)
    //         e.preventDefault()
    //
    //     //add space after 3rd number
    //     e.target.value = e.target.value.replace(/[^\dA-Z]/g, '').replace(/(.{3})/g, '$1 ').trim()
    //
    //     // only 5 numbers
    //     if (e.target.value.length > 5)
    //         e.preventDefault()
    //
    // }

    // validate every input
    validateInput(input) {

        let valid = true

        if (input.value.trim() === '') {
            input.parentElement.classList.remove('valid')
            input.parentElement.classList.add('invalid')
            valid = false
        }
        else {
            input.parentElement.classList.add('valid')
            input.parentElement.classList.remove('invalid')
        }


        if (input.id === 'town') {
            if( isNaN(input.value) ) {
                input.parentElement.classList.remove('valid')
                input.parentElement.classList.add('invalid')
                valid = false
            }
            else {
                input.parentElement.classList.add('valid')
                input.parentElement.classList.remove('invalid')
            }
        }

        // zip code must be 6 chars long
        if (input.id === 'zipCode') {
            if (input.value.length < 6) {
                input.parentElement.classList.remove('valid')
                input.parentElement.classList.add('invalid')
                valid = false
            }
        }

        if (input.id === 'email') {
            if (!this.validateEmail(input.value)) {
                input.parentElement.classList.remove('valid')
                input.parentElement.classList.add('invalid')
                valid = false
            }
            else {
                input.parentElement.classList.add('valid')
                input.parentElement.classList.remove('invalid')
            }
        }

        if (input.id === 'phone') {
            // const code = input.value[0] + input.value[1] + input.value[2] + input.value[3]

            input.value = input.value.trim()

            if (input.value.replace(/ /g,'').length === 13 || input.value.replace(/ /g,'').length === 10) {
                input.parentElement.classList.add('valid')
                input.parentElement.classList.remove('invalid')
            }
            else {
                input.parentElement.classList.remove('valid')
                input.parentElement.classList.add('invalid')
                valid = false
            }

        }

        if (! valid) {

            // resetting animation
            if (input.parentElement.classList.contains('bounce')) {
                // reset animation
                input.parentElement.classList.remove('bounce')
                // trigger reflow
                input.parentElement.offsetWidth
            }
            input.parentElement.classList.add('bounce')

        }

        return valid
    }

    validateEmail(email) {
        const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(String(email).toLowerCase());
    }

    validatePhone(e) {
        e.target.value = e.target.value.replace(/[^0-9\s]/g, "")
    }

    active(label) {
        if (! label.classList.contains('label-active'))
            label.classList.add('label-active')
        else
            label.classList.remove('label-active')
    }

    filled(label) {
        if (! label.classList.contains('label-active'))
            this.active(label)

        if (! label.classList.contains('label-filled') )
            label.classList.add('label-filled')
        else
            label.classList.remove('label-filled')
    }

}