# PicoMailFormsPlugin
PicoMailForms is a plugin for [Pico](http://picocms.org/) which allows you to define a form and send a mails
to a configured smtp server on submitting.

Forms can be written entirely in Markdown using custom markdown extensions. The mail is then being sent using [PHPMailer](https://github.com/PHPMailer/PHPMailer).

PicoMailForms has been developed keeping CleanCode in mind. Unfortunately I'm not very familiar with PHP and the UnitTest coverage is therefore very low. The IntegrationTest coverage reaches 93%.  
Pull requests are welcome!

### Use cases
- Registration forms
- Contact forms
- and more...

### Features
- Markdown extension for forms
- Mail success / error page after form submit
- Operator mail
- Custom success / error message
- Bootstrap forms
- Error Mail to administrator
- 93% test coverage

### Installation
Install the plugin using composer: `composer require jflepp/picomailformsplugin`.

### Small Example
_Configuration_
~~~ yaml
Mail:
    SenderName: test.ch
    Host: server.test.ch
    UserName: test@test.ch
    Password: test
    Port: 587
    OperatorMail: testuser@test.ch
~~~

_Form_ 
~~~~ 
[form]
  [text mail]E-Mail[/text]
  [text]some other information[/text]
[/form]
~~~~

_Operator Mail_

A user has successfully filled your form: test

<table>
  <tr><td>mail</td><td>example@customer.com</td></tr>
  <tr><td>first_name</td><td>Hans</td></tr>
  <tr><td>last_name</td><td>Zimmer</td></tr>
  <tr><td>some_other_information</td><td>This is me</td></tr>
</table>

### configuration
Configuring PicoMailFormsPlugin is straight forward.
~~~~ yaml
Mail:
    SenderName: MyWebsite
    Host: smpt.myprovider.com
    UserName: web@myprovider.com
    Password: apassword
    Port: 587
    OperatorMail: iamtheoperator@myprovider.com

Forms:
    UseBootstrap: true
~~~~

## Full form
~~~~
[form]
    [subject]Registration for event XY[/subject]
    [success]You successfully registered for the event XY! You're going to receive more information asap[/success]
    [failed]Registration failed. The site administrator has already been informed.[/failed]
    [text mail]Mail[/text]
    [text firstname]First name[/text]
    [text lastname]Last name[/text]
    [text]Address[/text]
    [text]Other informations[/text]
[/form]
~~~~

- `[form]` The beginning / end of a form. All data inbetween will be either interpreted or lost
- `[success]` Defines the success message shown on the webpage and in the mail
- `[failed]` The fail message shown on the page when a mail failed
- `[text]` Will be transformed to a text input, the text inbetween will be used as label
- `[text mail]` A usual text input which signalizes PicoMailForms that this is where the user mail is being specified. You can use any label you want. This is the only field required in a form.
- `[text firstname][text lastname]` The first name and last name of the user. It will be set as receivername of the usermail.
