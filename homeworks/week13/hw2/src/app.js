// eslint-disable-next-line
export function get_discussion(get_url, cursor, site_key, appendToElement) {
  $.ajax({
    method: 'GET',
    url: get_url,
    data: {
      site_key,
      cursor
    },
    cache: false
  }).done((data) => {
    if (data.message === 'success') {
      const discussions = data.discussion
      if (discussions.length < 6) {
        for (let i = 0; i < discussions.length; i += 1) {
          append_new_discussion(appendToElement, discussions[i], false)
        }
        $('#load_more').hide()
      } else {
        for (let i = 0; i < discussions.length - 1; i += 1) {
          append_new_discussion(appendToElement, discussions[i], false)
        }
        cursor = discussions[discussions.length - 2].id
        $('#load_more').attr('data-cursor', cursor)
      }
    }
  }).fail((jqxhr, textStatus, error) => {
    console.log(error)
  })
}
// eslint-disable-next-line
export function append_new_discussion(container, discussion, isPrepend) {
  const template = `<div class="card">

  <div class="card__avatar"></div>
    <div class="card__body">
      <div class="card__info">
        <span class="card__author">${escape_str(discussion.nickname)}</span>
        <span class="card__time">${escape_str(discussion.created_at)}</span>
      </div>
      <p class="card__content">${escape_str(discussion.content)}</p>
    </div>
  </div>`

  if (isPrepend) {
    container.prepend(template)
  } else {
    container.append(template)
  }
}
/* eslint-disable */
export function escape_str(output) {
  return output.replace(/\&/g, '&amp;')
    .replace(/\</g, '&lt;')
    .replace(/\>/g, '&gt;')
    .replace(/\"/g, '&quot;')
    .replace(/\'/g, '&#x27')
    .replace(/\//g, '&#x2F')
}
/* eslint-enable */
