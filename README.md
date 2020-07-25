<h1 align="center">Laravel H</h1>

<p align="center">
    <a href="https://packagist.org/packages/haruncpi/laravel-h"><img src="https://badgen.net/packagist/v/haruncpi/laravel-h" /></a>
    <a href="https://creativecommons.org/licenses/by/4.0/"><img src="https://badgen.net/badge/licence/CC BY 4.0/23BCCB" /></a>
     <a href=""><img src="https://badgen.net/packagist/dt/haruncpi/laravel-h"/></a>
    <a href="https://twitter.com/laravelarticle"><img src="https://badgen.net/badge/twitter/@laravelarticle/1DA1F2?icon&label" /></a>
    <a href="https://facebook.com/laravelarticle"><img src="https://badgen.net/badge/facebook/laravelarticle/3b5998"/></a>
</p>
<p align="center">A helper package for Laravel Framework.</p>

### Helpers
You can use all helper class method by `H::method()` or `h()->method()`
<table>
<tr>
<td>

`H::isLoggedIn()` <br> 
`H::numToWord(12.23)`
</td>

<td>

`h()->isLoggedIn()` <br> `h()->numToWord(12.23)`

</td>
</tr>
</table>

`isLocalhost()` - Check app is running on localhost or not.
```php
H::isLocalhost()
//output true
```

`isLoggedIn($guard)` - Check user is logged in or not. `$guard` by default null.
```php
H::isLoggedIn()
//output false
H::isLoggedIn('customer'); // for specific auth guard
//output true
```

`getUsername($guard)` - Get the current logged in user name. `$guard` by default null.
```php
H::getUsername()
//output Jhon Doe
```

`getUserId($guard)` - Get the current logged in user id. `$guard` by default null.
```php
H::getUserId()
//output 1
```

`getUserEmail($guard)` - Get the current logged in user email address. `$guard` by default null.
```php
H::getUserEmail()
//output 1
```

`getCurrentUser($guard)` - Get the current logged in user. `$guard` by default null.
```php
H::getCurrentUser()
```

`toMoney($amount, $decimal = 2)` - Get number to currency format.
```php
H::toMoney(200)
//output 200.00
H::toMoney(12.568)
//output 12.57
```
`numberToWord($amount, $option = ['decimal' => 'dollar', 'fraction' => 'cents'])` - Get number to words string.
```php
H::numberToWord(200)
//output two hundred
H::numberToWord(200.12)
//output two hundred dollar one two cents
```


### Form Helpers
You can use all form helper method by `F::method()` or `f()->method()`

<table>
<tr>
<td>

`F::text('name')`<br>`F::number('roll')`

</td>
<td>

`f()->text('name')`<br>`f()->number('roll')`

</td>
</tr>
</table>


`open($options)` - Open form tag.
```php
F::open(['url'=>'submit'])

/** output 
<form action="example.com/submit" method="POST">
<input type="hidden" name="_token" value="FwrnW3SOkLHKHsJctWnCeyZrOFtW6UtSHRf5XGrv"/>
*/
```

`close()` - Close form tag.
```php
F::close()
//output </form>
```

`label($name)` - Input label.
```php
F::label('name')
//output <label for="name">Name</label>
```

`text($name, $value = null, $attr = [])` - Form text box.
```php
F::text('first_name')
//output <input type="text" name="first_name"/>

F::text('first_name', $data->name, ['class'=>'form-control'] )
//output <input type="text" name="first_name" value="Jhon Doe" class="form-control"/>
```

`email($name, $value = null, $attr = [])` - Form email type input box.
```php
F::email('user_email')
//output <input type="email" name="user_email"/>
```

`password($name, $value = null, $attr = [])` - Form password type input box.
```php
F::password('password')
//output <input type="password" name="password"/>
```

`number($name, $value = null, $attr = [])` - Form number type input box.
```php
F::number('roll')
//output <input type="number" name="roll"/>
```

`hidden($name, $value = null, $attr = [])` - Form hidden input box.
```php
F::number('user_type')
//output <input type="hidden" name="user_type"/>
```

`textarea($name, $value = null, $attr = [])` - Form textarea.
```php
F::textarea('description')
//output <textarea name="description"></textarea>
```

`select($name,$list,$selected,$attr)` - Form select box.
```php
$list = [1 => 'Jhon', 2 => 'Adam'];
F::select('user_id',$list,null);

/** output 
<select name="user_id">
    <option value="1">Jhon</option>
    <option value="2">Adam</option>
</select>
*/
```