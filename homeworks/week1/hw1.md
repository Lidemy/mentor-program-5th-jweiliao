## 交作業流程

1. remote 複製專案到 local `git clone https://github.com/Lidemy/{yourUserName}.git`
2. 新開一個 **branch week1** 同時切換過去 `git checkout -b {branchName}`
3. push 前先檢查變動哪些檔案 `git status`，檢查更改內容 `git diff`
4. 沒有新增檔案時，可用 `git commit -am {message}` 加入版控新增訊息
5. 將新的分支推至 remote `git push origin {branchName}`
6. 發 PR(pull request)