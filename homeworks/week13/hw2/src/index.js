// eslint-disable-next-line
import { get_discussion, append_new_discussion } from './app'

export default function init(options) {
  let cursor = null
  const appendToElement = $(options.appendToElement)
  get_discussion(options.get_url, cursor, options.site_key, appendToElement)

  $('.board__new-comment-form').submit((e) => {
    e.preventDefault()
    const data = {
      site_key: options.site_key,
      nickname: $('input[name=nickname]').val().trim(),
      content: $('textarea[name=content]').val().trim()
    }
    $.ajax({
      method: 'POST',
      url: options.add_url,
      data,
      cache: false
    }).done((res) => {
      if (res.message === 'success') {
        const [discussion] = res.discussion
        append_new_discussion(appendToElement, discussion, true)

        $('input[name=nickname]').val('')
        $('textarea[name=content]').val('')
      }
    })
  })
  $('#load_more').on('click', (e) => {
    cursor = $(e.target).attr('data-cursor')
    get_discussion(options.get_url, cursor, options.site_key, appendToElement)
  })
}
