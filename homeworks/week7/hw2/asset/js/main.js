const accordionHearder = document.getElementsByClassName('accordion-hearder')

function accordion() {
  for (let i = 0; i < accordionHearder.length; i++) {
    accordionHearder[i].addEventListener('click', () => {
      const _this = accordionHearder[i]
      const accordionContent = _this.nextElementSibling
      const times = 0
      accordionContent.style.opacity = 0
      _this.classList.toggle('collapse')

      const setTimer = setInterval(() => {
        // _this.nextElementSibling.style.opacity = parseFloat(_this.nextElementSibling.style.opacity) + 0.1
        accordionContent.style.opacity = (parseFloat(accordionContent.style.opacity) === 1) ? clearInterval(setTimer) : parseFloat(accordionContent.style.opacity) + 0.1
      }, times)
    })
  }
}

accordion()
