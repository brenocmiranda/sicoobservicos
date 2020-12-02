Attribute VB_Name = "Módulo1"
Sub GetAttachments(Email As MailItem)
  Dim DiretorioAnexos As String
  Dim Anexo As Outlook.Attachment
  Dim strExtension As String

  DiretorioAnexos = "C:\wamp64\www\sicoob\outlook"

  For Each Anexo In Email.Attachments
      Anexo.SaveAsFile DiretorioAnexos & "\" & Anexo.FileName
      Email.Delete
  Next Anexo
End Sub
