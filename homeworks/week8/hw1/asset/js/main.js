const url = 'https://dvwhnbka7d.execute-api.us-east-1.amazonaws.com/default/lottery'
const config = { headers: { 'Content-Type': 'application/json' } }
const luckyDraw = document.querySelector('.lucky-draw')

luckyDraw.addEventListener('click', (e) => {
  const _this = e.target
  e.preventDefault()
  _this.classList.add('isDisabled')
  // eslint-disable-next-line
  axios.get(url, config)
    .then((response) => {
      const result = response.data.prize
      const fullBanner = document.querySelector('.lucky-draw-box').parentNode
      const drawBox = document.querySelectorAll('.lucky-draw-text')
      const title = document.querySelector('.lucky-draw-title')
      const drawResult = document.querySelector('.lucky-draw-result')

      console.log(result)

      for (let i = 0; i < drawBox.length; i++) {
        drawBox[i].classList.add('hide')
      }

      fullBanner.addEventListener('animationend', (e) => {
        fullBanner.classList.remove('animate__animated', 'animate__fadeIn')
      })
      drawResult.addEventListener('animationend', (e) => {
        drawResult.classList.remove('animate__animated', 'animate__fadeInDown', 'animate__bounceIn')
      })
      title.classList.add('hide')
      drawResult.classList.remove('hide')

      switch (result) {
        case 'NONE':
          awards.none(fullBanner, drawResult)
          break
        case 'THIRD':
          awards.third(fullBanner, drawResult)
          break
        case 'SECOND':
          awards.second(fullBanner, drawResult)
          break
        case 'FIRST':
          awards.first(fullBanner, drawResult)
          break
        default:
          awards.responseError(fullBanner, drawResult)
          break
      }

      _this.classList.remove('isDisabled')
    })
    .catch((error) => {
      const fullBanner = document.querySelector('.lucky-draw-box').parentNode
      const drawResult = document.querySelector('.lucky-draw-result')

      awards.responseError(fullBanner, drawResult)
      console.log(error)
      console.log(`${error.response.status} ???????????????????????????????????????`)
      // eslint-disable-next-line
      Swal.fire({
        title: '?????????????????????????????????',
        confirmButtonText: '??????',
        icon: 'warning',
        showClass: {
          popup: 'animate__animated animate__fadeInDown'
        },
        hideClass: {
          popup: 'animate__animated animate__fadeOutUp'
        }
      })
      // console.log(error.response.headers)
      _this.classList.remove('isDisabled')
    })
    .then(() => {})
})

const awards = {
  none: (fullBanner, drawResult) => {
    drawResult.classList.add('animate__animated', 'animate__fadeInDown')
    drawResult.textContent = '??????????????????'
    fullBanner.className = 'full-banner-none'
  },
  third: (fullBanner, drawResult) => {
    drawResult.classList.add('animate__animated', 'animate__fadeInDown')
    drawResult.textContent = '????????????????????????????????? YouTuber ?????????????????????????????????bang??????'
    fullBanner.className = 'full-banner-third'
  },
  second: (fullBanner, drawResult) => {
    drawResult.classList.add('animate__animated', 'animate__fadeInDown')
    drawResult.textContent = '???????????????????????????90 ?????????????????????'
    fullBanner.className = 'full-banner-second'
  },
  first: (fullBanner, drawResult) => {
    drawResult.classList.add('animate__animated', 'animate__bounceIn')
    drawResult.textContent = '????????????????????????????????????????????????????????????'
    fullBanner.className = 'full-banner-first animate__animated animate__fadeIn'
  },
  responseError: (fullBanner, drawResult) => {
    // eslint-disable-next-line
    Swal.fire({
      title: '?????????????????????????????????',
      confirmButtonText: '??????',
      icon: 'warning',
      showClass: {
        popup: 'animate__animated animate__fadeInDown'
      },
      hideClass: {
        popup: 'animate__animated animate__fadeOutUp'
      }
    })

    drawResult.classList.add('animate__animated', 'animate__fadeInDown')
    drawResult.textContent = '???????????????????????????????????????'
    fullBanner.className = 'full-banner'
  }
}
