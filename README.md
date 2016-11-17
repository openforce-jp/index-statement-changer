# index-statement-changer
":str" type satement changes "?"

# How to use

<pre>
<code>
$sc = new \Of\StatementChanger("select * from my_table where created_at > :date ", ["date" => "2016-11-17"]);
$sc->execute();
print($sc->getsql());
print_r($sc->getParameters());
</code>
</pre>
