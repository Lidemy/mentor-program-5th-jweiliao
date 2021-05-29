const slides = document.querySelector('.slider').children
const prev = document.querySelector('.prev')
const next = document.querySelector('.next')
const dots = document.querySelector('.dots')
// 參數化
let index = 0
const times = 4000
// const autoPlay = true

prev.addEventListener('click', () => {
  prevSlide()
  updateDots()
  resetTimer()
})
next.addEventListener('click', () => {
  nextSlide()
  updateDots()
  resetTimer()
})
// 動態建立指標，各別綁定事件
function createDots() {
  for (let i = 0; i < slides.length; i++) {
    const _div = document.createElement('div')
    // div.innerHTML=i+1;
    _div.setAttribute('onclick', 'dotsSlide(this)')
    _div.id = i
    if (i === 0) {
      _div.className = 'active'
    }
    dots.appendChild(_div)
  }
}
createDots()
// eslint-disable-next-line
function dotsSlide(dot) {
  index = dot.id
  changeClass()
  updateDots()
  resetTimer()
}
// 移除所有 class，在當前的索引加上 active
function updateDots() {
  // for (let i = 0; i < dots.children.length; i++){
  //   dots.children[i].classList.remove('active')
  // }
  [...dots.children].forEach((dot) => {
    dot.classList.remove('active')
  })
  dots.children[index].classList.add('active')
}
// 如果 index 已經是第一張，就從最後開始
function prevSlide() {
  // eslint-disable-next-line
  if (index == 0) {
    index = slides.length - 1
  } else {
    index--
  }
  changeClass()
}
// 如果 index 已經是最後一張，就重頭開始
function nextSlide() {
  // eslint-disable-next-line
  if (index == slides.length - 1) {
    index = 0
  } else {
    index++
  }
  changeClass()
}
// 移除所有 class，在當前的索引加上 active
function changeClass() {
  // for(let i = 0; i < slides.length; i++) {
  //   slides[i].classList.remove('active')
  // }
  [...slides].forEach((slide) => {
    slide.classList.remove('active')
  })
  slides[index].classList.add('active')
}
// 選到指標，將時間重置
function resetTimer() {
  clearInterval(timer)
  timer = setInterval(autoPlay, times)
}
function autoPlay() {
  nextSlide()
  updateDots()
}
let timer = setInterval(autoPlay, times)
