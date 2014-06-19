function slidedown(the_layer)
{
  if(document.getElementById(the_layer))
  {
    if(document.getElementById(the_layer).style.display == 'none')
    {
      document.getElementById(the_layer).style.display = 'inline';
    }
    else
    {
      document.getElementById(the_layer).style.display = 'none';
    }
  }
}