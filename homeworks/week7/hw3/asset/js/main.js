// global variable
const listElement = document.querySelector('.list')
const addElement = document.querySelector('.btn-add')
// eslint-disable-next-line
const checkElement = document.querySelectorAll('.btn-check')
// eslint-disable-next-line
const removeElement = document.querySelectorAll('.btn-delete')
const times = 350
// check
// for(var i = 0; i < checkElement  .length; i++){
//   checkElement[i].addEventListener('click', (e) => {
//     if (e.target.tagName == 'I' && e.target.innerText === 'check_box') {
//       e.target.innerText = 'check_box_outline_blank'
//     } else if (e.target.tagName == 'I' && e.target.innerText === 'check_box_outline_blank') {
//       e.target.innerText = 'check_box'
//     }
//   })
// }
// delete
// for(var i = 0; i < removeElement.length; i++){
//   removeElement[i].addEventListener('click', (e) => {
//     if (e.target.classList.contains('btn-delete')) {
//       e.target.parentElement.parentElement.remove()
//     } else {
//       e.target.parentElement.parentElement.parentElement.remove()
//     }
//   })
// }
// create
// addElement.addEventListener('click', (e) => {
//   let newItem = '<li><span></span><div class="action"><button type="button" class="btn-check"><i aria-hidden="true" class="material-icons">check_box_outline_blank</i></button><button class="btn-delete"><i aria-hidden="true" class="material-icons">delete</i></button></li>'
//   let newElement = document.createElement('DIV')
//   newElement.innerHTML = newItem;

//   while (newElement.firstChild) {
//     listElement.appendChild(newElement.firstChild);
//   }
// })

listElement.addEventListener('click', (e) => {
  function checkItem(e) {
    // if (e.target.closest('li'))
    if (e.target.tagName === 'I' && e.target.innerText === 'check_box') {
      e.target.innerText = 'check_box_outline_blank'
      e.target.parentElement.parentElement.parentElement.classList.remove('done')
    } else if (e.target.tagName === 'I' && e.target.innerText === 'check_box_outline_blank') {
      e.target.innerText = 'check_box'
      e.target.parentElement.parentElement.parentElement.classList.add('done')
    }
    checkStatus()
  }

  function removeItem(e) {
    // console.log(e.target.innerText)
    // console.log(e.target.parentElement.parentElement.parentElement)

    // closest 方法 IE 不支援
    // if (e.target.closest('li')) {
    //   let li = e.target.closest('li')
    //   li.style.opacity = '0'
    //   setTimeout(() => {
    //     listElement.removeChild(li)
    //     checkStatus()
    //   }, times)
    // }

    if (e.target.classList.contains('btn-delete')) {
      const li = e.target.parentElement.parentElement
      li.style.opacity = '0'
      setTimeout(() => {
        li.parentNode.removeChild(li)
        checkStatus()
      }, times)
    } else if (e.target.innerText === 'delete') {
      const li = e.target.parentElement.parentElement.parentElement
      li.style.opacity = '0'
      setTimeout(() => {
        li.parentNode.removeChild(li)
        checkStatus()
      }, times)
    }
  }

  checkItem(e)
  removeItem(e)
})

function createItem() {
  document.querySelector('.add-item').addEventListener('keyup', (e) => {
    const newel = document.querySelector('.add-item')
    const newText = newel.value
    const inputText = document.querySelector('.add-item')

    if (e.keyCode === 13) {
      const newItem = `<li><span>${newText}</span><div class="action"><button type="button" class="btn-check"><i aria-hidden="true" class="material-icons">check_box_outline_blank</i></button><button class="btn-delete"><i aria-hidden="true" class="material-icons">delete</i></button></li>`
      const newElement = document.createElement('DIV')
      newElement.innerHTML = newItem

      if (newText === '') {
        inputText.placeholder = 'PLease enter your tasks here'
        inputText.classList.add('animate__animated', 'animate__headShake')
        inputText.addEventListener('animationend', (e) => {
          inputText.classList.remove('animate__animated', 'animate__headShake')
        })
        return
      }

      while (newElement.firstChild) {
        listElement.appendChild(newElement.firstChild)
      }

      document.querySelector('.add-item').placeholder = ''
      newel.value = ''
      checkStatus()
    }
  })
  addElement.addEventListener('click', (e) => {
    const newel = document.querySelector('.add-item')
    const newText = newel.value
    const inputText = document.querySelector('.add-item')
    const newItem = `<li><span>${newText}</span><div class="action"><button type="button" class="btn-check"><i aria-hidden="true" class="material-icons">check_box_outline_blank</i></button><button class="btn-delete"><i aria-hidden="true" class="material-icons">delete</i></button></li>`
    const newElement = document.createElement('DIV')

    if (newText === '') {
      inputText.placeholder = 'PLease enter your tasks here'
      inputText.classList.add('animate__animated', 'animate__headShake')
      inputText.addEventListener('animationend', (e) => {
        inputText.classList.remove('animate__animated', 'animate__headShake')
      })
      return
    }

    newElement.innerHTML = newItem

    while (newElement.firstChild) {
      listElement.appendChild(newElement.firstChild)
    }

    document.querySelector('.add-item').placeholder = ''
    newel.value = ''
    checkStatus()
  })
}

function checkStatus() {
  const liElement = document.querySelectorAll('.list > li')
  const emptyList = document.querySelector('.empty-list')
  const complete = document.querySelector('.complete')
  const todo = document.querySelector('.needTodo')
  let sum = 0
  let needTodo = 0

  for (let i = 0; i < liElement.length; i++) {
    if (liElement[i].classList.contains('done')) {
      sum++
    } else {
      needTodo++
    }
  }

  complete.innerHTML = `Done: ${sum}`
  todo.innerHTML = `To do: ${needTodo}`

  if (!liElement.length) {
    emptyList.style.display = 'block'
  } else {
    emptyList.style.display = 'none'
  }
}

createItem()
checkStatus()
