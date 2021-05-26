## 什麼是 DOM？
**DOM** 文件物件模型（Document Object Model），是 HTML、XML、SVG 的程式介面，它提供了一個方法，使我們能夠使用 JavaScript 訪問更改、增加或刪除 HTML 的所有元素，但它本身不屬於 Javascript 的一部份，當瀏覽器載入一個頁面時，它會建立「**DOM Tree**」的模型，並保存於瀏覽器的記憶體中，這個模型由4個節點組成。

![Dom tree](https://www.w3schools.com/js/pic_htmltree.gif)

+ 文件節點 (Documet):
  在這顆樹的頂點就是文件節點，它呈現整個頁面，訪問任何元素、屬性、文字節點，都需要透過 Documet 進行。 

+ 元素節點 (Element):
  HTML 描述了整個 HTML的結構，如 `<h1> ~ <h6>` 描述標題部分，`<p>` 表示文字或文字段落。 

+ 屬性節點 (Attribute):
  HTML元素在開始標籤包含若干屬性，這些屬性在 「**DOM Tree**」形成屬性節點，它不屬於元素的一部份，而不是子節點。

  - Attribute 和 Property 都翻作"屬性"他們之間有什麼不同?
  有興趣的可以看這裡 [屬性(Attribute)與特性(Property)](https://jax-work-archive.blogspot.com/2011/07/attributeproperty.html)

+ 文字節點 (Text)
  訪問到元素節點時，可以訪問到元素內部的文本，文字節點沒有子元素。


## 事件傳遞機制的順序是什麼；什麼是冒泡，什麼又是捕獲？
![capture bubble](https://i.imgur.com/gfbH0Vj.jpg)
上圖模擬了整個 **DOM Event** 執行順序，從最上層開始執行`事件捕捉 (Capture)`，直到遇到 Second Grandchild 也就是我們的`目標 (targe)`，緊接著執行`冒泡事件 (Bubble)`。

![capture bubble](https://i.imgur.com/eVNAzLt.jpg)
如果我將 `目標 (targe)` 設為 First Grandchild，`捕獲事件`就不會向下繼續傳遞，接著在`目標階段`執行完畢在`冒泡`回最上層。



事件傳遞機制在 HTML 的模擬圖
![bc](https://i.imgur.com/ePUFgnV.png)


這是一個很棒的教學網站，模擬了事件傳遞機制的過程 [Dom Event](https://tinyurl.com/j6nfbcsw)

## 什麼是 event delegation，為什麼我們需要它？
如果我們用傳統綁定事件的方法，將這些元素 `<li>` 都各別都加上事件監聽，這樣的做法不僅效率低，實際上都是在執行同一件事，而且每多一個元素都要重新綁定一次事件，顯得很笨拙且沒必要。

![event delegation](https://i.imgur.com/msCcvKg.png)
![event delegation](https://i.imgur.com/eZfIYIb.png)

我們可以透過 **事件委託 event delegation**，利用事件會影響到父級元素或祖先元素的特性，將事件綁定在容器上，例如這個範例，將事件委託給 `<ul>`。

好處是只需要一個監聽事件就夠了，而且後來新增的元素也能綁定事件，因為我們把事件委託給他的父級元素，這樣不僅減少函式使用量、DOM 的關聯，讓維護及效能更容易更好。

![event delegation](https://i.imgur.com/qmUTSRz.png)

## event.preventDefault() 跟 event.stopPropagation() 差在哪裡，可以舉個範例嗎？

>**event.preventDefault()**
阻止事件的默認行為，但不影響事件的傳遞，也就無法阻止事件冒泡。
例如 `<a>`、`<input type="submit">`

![preventDefault](https://i.imgur.com/9UqcFv5.jpg)
上圖模擬 `preventDefault` 從`捕獲 (Capture)` 到`目標 (targe)`階段，在由 `冒泡 (Bubble)` 會到最上層的過程，皆不影響事件的傳遞。

```
<a href="假設有連結" id="link"></a>

let a = document.getElementById('link')
a.onclick = () => {
  if(e.preventDefault){
    e.preventDefault();
  }else{
    window.event.returnValue == false;
  }
}

// or use return false

a.onclick = () => {
  return false
}
```

或是使用 return false 也會阻止默認行為，但同樣無法阻止事件冒泡。
舊版 IE 使用 e.returnValue = false。

> 補充 `event.cancelable`，回傳 cancelable 的設定值，其為 true 或 false [event.cancelable](https://developer.mozilla.org/zh-CN/docs/Web/API/Event/cancelable)

>**event.stopPropagation()**
阻止目標元素的冒泡事件，後續的 handler 將不會被觸發，但是不會阻止默認行為。

![addEventListener](https://i.imgur.com/m1O6oqB.jpg)
補充 addEventListener 的第三個參數叫做useCapture，是一個布林值，接受 True 或 False，決定瀏覽器是以「捕獲」還是「冒泡」的機制進行，預設值是 False，所以是 「冒泡」的機制。

> 注意所有現代瀏覽器默認使用冒泡事件模型而不是捕獲事件模型，為了方便說明統一將事件設定在捕獲階段

![stopPropagation](https://i.imgur.com/QJToDIv.jpg)
我們在 `target` 設定 `stopPropagation`，首先從最上層開始執行捕獲事件直到遇到目標 `target`，之後 `stopPropagation` 阻止了事件繼續冒泡到最上層的元素。

在來看一個例子，假如有兩個事件都發生在同一層，一樣可以阻止`冒泡`，但這兩個事件都會被觸發。
![stopPropagation](https://i.imgur.com/DUvm7Yp.jpg)

那要怎麼只觸發其中一個事件呢，請使用 `event.stopImmediatePropagation`，功能就是 **立即停止** 接下來的事件傳遞，後面的事件將不會觸發。
![stopImmediatePropagation](https://i.imgur.com/f4K896Y.jpg)

> 補充 `Event.cancelBubble`僅組止事件冒泡的父元素，有興趣可以了解一下 [Event.cancelBubble](https://developer.mozilla.org/zh-CN/docs/Web/API/Event/cancelBubble)