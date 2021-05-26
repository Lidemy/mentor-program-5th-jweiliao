/*
** 表單驗證 v1 版
*/
const form = document.querySelector('#form')
const formName = form.getAttribute('name')
// eslint-disable-next-line
form.addEventListener('submit', e => {
  e.preventDefault()
  const formCheckEmptyName = formCheck(formName, ['userName', 'email', 'cellPhone', 'entry_type', 'details'])
  formErrMessage(formCheckEmptyName)

  // 當回傳結果大於 1 時，數字表示有多少必填欄位未填，若為 0，則通過
  if (formCheckEmptyName.length) {
    // eslint-disable-next-line
    return Swal.fire({
      title: '報名失敗!',
      text: '請再次確認您的表單欄位是否填妥',
      icon: 'error',
      showCancelButton: true,
      confirmButtonText: '確定'
    })
  }
  // 假的送出回報
  // eslint-disable-next-line
  Swal.fire({
    title: '報名成功!',
    text: '您的表單成功送出囉!',
    icon: 'success',
    showCancelButton: true,
    confirmButtonText: '確定'
  })
})

function formCheck(formName, fieldNames) {
  const form = document.forms[formName]
  // const form = document.forms[formName][fieldNames]
  // eslint-disable-next-line
  return fieldNames.filter((field) => {
    if (form[field].value.trim() === '') {
      return form[field]
    }

    if (form[field].length) {
      form[field][0].parentElement.parentElement.classList.remove('reqired')
    } else {
      form[field].parentElement.classList.remove('reqired')
    }
  })
}

function formErrMessage(formCheckEmptyName) {
  formCheckEmptyName.forEach((inputName) => {
    console.log(inputName)
    let inputs
    if (inputName === 'entry_type') {
      inputs = document.querySelector('input[name="entry_type"]')
      inputs.parentElement.parentElement.classList.add('reqired')
    } else {
      inputs = document.querySelector(`#${inputName}`)
      inputs.parentElement.classList.add('reqired')
    }
  })
}

// const userName = document.querySelector('#userName')
// const email = document.querySelector('#email')
// const details = document.querySelector('#details')
// const submit = document.querySelector('#submit')

// function checkInputs() {
//   const userNameValue = userName.value.trim()
//   const emailValue = email.value.trim()
//   const detailsValue = details.value.trim()

//   if(usernameValue === '') {
//     Swal.fire({
//       title: 'Error!',
//       text: 'Do you want to continue',
//       icon: 'error',
//       confirmButtonText: 'Cool'
//     })
//   }
// }

// function formCheck(formName, fieldNames) {
//   const form = document.forms[formName];
//   return fieldNames.some(field => !form[field].value);
// }

// isFormIncomplete(['username', 'email', 'cellphone'])
