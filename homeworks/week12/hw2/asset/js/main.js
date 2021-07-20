// global variable
const listElement = document.querySelector('.list')
const addElement = document.querySelector('.btn-add')
const times = 350

function escapeStr(output) {
  /* eslint-disable */
  return output.replace(/\&/g, '&amp;')
    .replace(/\</g, '&lt;')
    .replace(/\>/g, '&gt;')
    .replace(/\"/g, '&quot;')
    .replace(/\'/g, '&#x27')
    .replace(/\//g, '&#x2F')
  /* eslint-enable */
}

listElement.addEventListener('click', (e) => {
  function checkItem(e) {
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
      const newItem = `<li><span>${escapeStr(newText)}</span><div class="action"><button type="button" class="btn-check"><i aria-hidden="true" class="material-icons">check_box_outline_blank</i></button><button class="btn-delete"><i aria-hidden="true" class="material-icons">delete</i></button></li>`
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
    const newItem = `<li><span>${escapeStr(newText)}</span><div class="action"><button type="button" class="btn-check"><i aria-hidden="true" class="material-icons">check_box_outline_blank</i></button><button class="btn-delete"><i aria-hidden="true" class="material-icons">delete</i></button></li>`
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
    // 賦予 ID
    liElement[i].id = i + 1
    if (liElement[i].classList.contains('done')) {
      liElement[i].children[1].children[0].children[0].innerText = 'check_box'
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

$('.btn-all').on('click', () => {
  $('.list').children('li').show()
})

$('.btn-done').on('click', () => {
  $('.list').children('li.done').show().end().children('li').not('.done').hide()
})
$('.btn-undone').on('click', () => {
  console.log($('.list').children('li').not('.done').show().end().filter('li.done').hide())
})

const searchParams = new URLSearchParams(window.location.search)
const searchID = searchParams.get('id')

if (searchID) {
  $.getJSON(`http://mentor-program.co/mtr04group5/wei/week12/hw2/get_todo_list.php?id=${searchID}`)
    .done((res) => {
      let todos
      try {
        todos = JSON.parse(res.content[0].content)
      } catch (err) {
        console.log(err)
      }
      generateHTML(todos)
    })
}

function generateHTML(todos) {
  let templateHTML
  $('.list').empty()
  for (const todo of todos) {
    // eslint-disable-next-line
    const is_done = (todo.is_done) ? 'done' : ''
    // eslint-disable-next-line
    templateHTML = `<li id="${todo.id}" class="${is_done}"><span>${escapeStr(todo.content)}</span><div class="action"><button type="button" class="btn-check"><i aria-hidden="true" class="material-icons">check_box_outline_blank</i></button><button class="btn-delete"><i aria-hidden="true" class="material-icons">delete</i></button></li>`
    $('.list').append(templateHTML)
  }

  checkStatus()
}

$('.btn-save').on('click', (e) => {
  const content = []
  $('.list').children('li').each((i, e) => {
    content.push({
      id: $(e).closest('li').attr('id'),
      content: $(e).find('span').text(),
      // eslint-disable-next-line
      is_done: ($(e).closest('li').hasClass('done')) ? true : false
    })
  })
  console.log(content)
  $.ajax({
    method: 'GET',
    url: 'http://mentor-program.co/mtr04group5/wei/week12/hw2/save_todo_list.php',
    data: {
      content: JSON.stringify(content)
    },
    dataType: 'json',
    cache: false
  }).done((res) => {
    if (res.message === 'success') {
      window.location.replace(`index.html?id=${res.id}`)
    }
  }).fail((jqxhr, textStatus, error) => {
    console.log(error)
  })
})

createItem()
checkStatus()
