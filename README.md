# FPDF EasyTable

It is a PHP class that provides an easy way to make tables for PDF documents that are generated with the 
[FPDF library](http://www.fpdf.org).

Making tables for PDF documents with this class is as easy and flexible as
making HTML tables. And using CSS-style strings we can customize the look of 
the tables in the same fashion HTML tables are styling with CSS. 

No messy code with confusing arrays of attributes and texts.

No complicated configuration files.

Building and styling a table with easyTable is simple, clean and fast.

```
 $table=new easyTable($pdf, 3, 'width:100;');
 
 $table->easyCell('Text 1', 'rowspan:2; valign:T'); 
 $table->easyCell('Text 2', 'bgcolor:#b3ccff; rowspan:2');
 $table->easyCell('Text 3');
 $table->printRow();
 
 $table->rowStyle('min-height:20');
 $table->easyCell('Text 4', 'bgcolor:#3377ff; rowspan:2');
 $table->printRow();

 $table->easyCell('Text 5', 'bgcolor:#99bbff;colspan:2');
 $table->printRow();
 
 $table->endTable();
```

# Content
 
- [Features](#features)
- [Comparisons](#comparisons)
- [Examples](#examples)
- [Requirements](#requirements)
- [Manual Install](#manual-install)
- [Quick Start](#quick-start)
- [Documentation](#documentation)
- [Fonts And UTF8 Support](#fonts-and-utf8-support)
- [Using with FPDI](#using-with-fpdi)
- [Tag based font style](#tag-based-font-style) **_NEW FEATURE!!_**
- [Common error](#common-error)
- [Get In Touch](#get-in-touch)
- [Donations](#donations)
- [License](#license)

# Features

- Table and columns width can be defined in mm or percentage

- Every table cell is a fully customizable 
  (font family, font size, font color, background color, position of the text, 
  vertical padding, horizontal padding...)

- Cells can span to multiple columns and rows

- Tables split automatically on page-break

- Set of header row, so the header can be added automatically on every new page

- Attribute values can be defined globally, at the table level (affect all the cells in the table), 
  at the row level (will affect just the cells in that row), or locally at the cell level

- Rows can be set to split on page break if it does not fit in the current page or to be printed
  on the next page

- Images can be added to table cells

- Text can be added on top or below an image in a cell

- [UTF8 Support](#fonts-and-utf8-support)

- [Tag based font style](#tag-based-font-style) which allows to mix different font families, font styles, font size and font color in the same cell! **_NEW FEATURE!!_** 

- [Links](#tag-based-font-style) **_NEW FEATURE!!_** 




# Comparisons

**easyTable vs kind-of-HTML-to-PDF**

To use HTML code to make tables for PDF documents is a kind of sloppy hack. To begin with
to convert HTML code into a kind of FPDF you need a parcer meaning there is a penalty in performace;
and second the results are very poor. 

*HTML code*

    <table align:"right" style="border-collapse:collapse">
      <tr>
        <td rowspan="2" style="width:30%; background:#ffb3ec;">Text 1</td>
        <td colspan="2" style="background:#FF66AA;">Text 2</td>
      </tr>
      <tr>
        <td style="width:35%; background:#33ffff;">Text 3 </td>
        <td style="width:35%; background:#ffff33;">Text 4 </td>
      </tr>
    </table>

*easyTable code*

    $table=new easyTable($pdf, '%{30, 35, 35}', 'align:R; border:1');
      $table->easyCell('Text 1', 'rowspan:2; bgcolor:#ffb3ec');
      $table->easyCell('Text 2', 'colspan:2; bgcolor:#FF66AA');
      $table->printRow();

      $table->easyCell('Text 3', 'bgcolor:#33ffff');
      $table->easyCell('Text 4', 'bgcolor:#ffff33');
      $table->printRow();
    $table->endTable(5);



# Examples

- [Evolution of a table](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-1.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example1.php)
  
- [Table with header](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-2.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example2.php)

- [Simple invoice](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-3.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example3.php)

- [More examples](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-4.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example4.php)
 

# Requirements

- PHP 5.6 or higher
- [FPDF 1.81](http://www.fpdf.org).
- exfpdf.php (included in this project)

# Manual Install

Download the EasyTable class and FPDF class and put the contents in a directory in your project structure.
Be sure you are using [FPDF 1.81](http://www.fpdf.org).

# Quick Start

- create a fpdf object with exfpdf class (extension of fpdf class)
- create a easyTable object
```
    $table=new easyTable($pdf, 3, 'border:1');
```    
- add some rows
```
    $table->easyCell('Text 1', 'valign:T'); 
    $table->easyCell('Text 2', 'bgcolor:#b3ccff;');
    $table->easyCell('Text 3');
    $table->printRow();

    $table->rowStyle('min-height:20; align:{C}');   // let's adjust the height of this row
    $table->easyCell('Text 4', 'colspan:3');
    $table->printRow();
```
- when it is done, do not forget to terminate the table
```
    $table->endTable(4);
```
  [Result](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.php)


# Documentation

**function __construct( FPDF-object $fpdf_obj, Mix $num_cols[, string $style = '' ])**

*Description:*

   Constructs an easyTable object

*Parameters:*

fpdf_obj

    the current FPDF object (constructed with the FPDF library)  
    that is being used to write the current PDF document

num_cols

    this parameter can be a positive integer (the number of columns)
    or a string of the following form
   
    I) a positive integer, the number of columns for the table. The width of every 
    column will be equal to the width of the table (given by the width property) divided by 
    the number of columns ($num_cols)

    II) a string of the form '{c1, c2, c3,... cN}'. In this case every element in the curly 
    brackets is a positive numeric value that represent the width of a column. Thus, 
    the n-th numeric value is the width of the n-th colum. If the sum of all the width of 
    the columns is bigger than the width of the table but less than the width of the document, 
    the table will stretch to the sum of the columns width. However, if the sum of the columns 
    is bigger than the width of the document, the width of every column will be reduce proportionally 
    to make the total sum equal to the width of the document. 

    III) a string of the form '%{c1, c2, c3,... cN}'. Similar to the previous case, but this time 
    every element represents a percentage of the width of the table. In this case it the sum of 
    this percentages is bigger than 100, the execution will be terminated.

style

    the global style for the table (see documentation) a semicolon-separated string of attribute 
    values that defines the default layout of the table and all the cells and their contents 
    (see Documentation section in README.md)

*Examples:*
```
    $table= new easyTable($fpdf, 3);
    $table= new easyTable($fpdf, '{35, 45, 55}', 'width:135;');
    $table= new easyTable($fpdf, '%{35, 45, 55}', 'width:190;');
```   
   
*Return value:*

   An easyTable object    


**function rowStyle( string $style )**

*Description:*

   Set or overwrite the style for all the cells in the current row.

*Parameters:*

style
   
   a semicolon-separated string of attribute values that defines the 
   layout of all the cells and its content in the current row 
   (see Documentation section in README.md)

*Return values*

   Void
   
*Notes:*

   This function should be called before the first cell of the current row


**function easyCell( string $data [, string $style = '' ])**

*Description:*

    Makes a cell in the table

*Parameters:*

data   
    the content of the respective cell

style (optional)
    a semicolon-separated string of attribute values that defines the 
    layout of the cell and its content (see Documentation section in README.md)

*Return value*

    void
   


**function printRow ( [ bool $setAsHeader = false ] )**

*Description:*

   This function indicates the end of the current row. 

*Parameters:*

setAsHeader (optional)
    When it is set as true, it sets the current row as the header
    for the table; this means that the current row will be printed as the first
    row of the table (table header) on every page that the table splits on.
    Remark: 1. In order to work, the table attribute split-row should set as false. 
            2. Just the first row where this parameter is set as true will be
               used as header any other will printed as a normal row.
            3. For row headers with cells that spans to multiple rows, 
               the last the parameter should be set in the last row 
               of the group. See [example 2](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/example-2.pdf)

*Return values*

   Void

*Note:*

   This function will print the current row as far as the following holds:
```   
      total_rowspan=0
```
   where total_rowspan is set as 
```   
      total_rowspan=max(total_rowspan, max(rowspan of cell in the current row))-1;
```             

**function endTable( [ int $bottomMargin = 2 ])**

*Description:*

   Unset all the data members of the easyTable object

*Parameters:*

bottomMargin (optional)

   Optional. Specify the number of white lines left after 
   the last row of the table. Default 2.
   
   If it is negative, the vertical position will be set before
   the end of the table.   

*Return values*

   Void


**Style String**

In the same fashion as in-line CSS style, Easy Table uses 
strings of semicolon-separated pairs of properties/values to
define the styles to be applied to the different parts of 
a table. A value set on a property at the table level will be inherited 
by all the rows (therefore all the cells) in the table. A value set
on a property at the row level, will be overwrite the value inherited from the table
and, will be passed to all the cells in that row, unless a cell 
defines its own value for that property.

In what follows, we are going to use the following notation:

    C=cell
    R=row
    T=table

**PROPERTY** [C/R/T] means that the property PROPERTY can be set on cells, rows, table. 

Full list of properties:

**width** [T]

The width property sets the width of a table.
This property can be defined in millimetres or in percentage of the width of the document.

Syntax:

    width:mm|%;

Examples:

    width:145;
    width:70%;

Default: the width of the document minus the right and left margin.
   
**border** [C/R/T]

The border property indicates if borders must be drawn around the cell or the cells. 
The value can be either a number:

    0: no border
    1: frame

or a string containing some or all of the following characters (in any order):

    L: left border
    T: top border
    R: right border
    B: bottom border

Default value: 0. 


**border-color** [C/R/T]

The border-color property is used to set the colour of the border to be drawn 
around the cells. The value can be: Hex color code or RGB color code.

Syntax:

    border-color: Hex |RGB;

Example:

    border-color:#ABCABC;
    border-color:#ABC;
    border-color:79,140, 200;

Default value: the current drawn colour set in the document

Note: beware that when set this attribute at the cell level, because the borders of the cells 
      overlap each other, the results might not be as expected on adjacent cell with different
      border color.


**border-width** [T]

The border-width property is used to set the width of the lines the border is made of.

Syntax:

    border-width:0.5;

Default value: the current drawing line width of the document.

Note: beware that if the border-width is set to thick, the border might overlap the content
      of the cells. In that case you will have to set appropriate paddingX and paddingY on the cells.
      (See paddingX and paddingY properties below).


**split-row** [T]

This property indicate if a row that is at the bottom of the page should be split or not
when it reaches the bottom margin, except for rows that contains cell that span
to different rows, in this case the row splits. By the fault, any row that does not fit in the page
is printed in the next page. Setting the property to false, it will split any row
between the pages. 

Example: 

    split-row:false;


**l-margin** [T]

This property indicate the distance from the left margin from where the table should start.

Syntax:

    l-maring:mm;

Example:

    l-maring:45;

Default value: 0.

**min-height** [R] 

The min-height property set the minimum height for all the cells (with rowspan:1) in that
specific row.

Syntax:

    min-height:mm;

Example:

    min-height:35;


Default value: 0.

**align** [C/R/T] 

This property indicates the horizontal alignment of the element in which it is set.
The values can be: 

    L: to the left
    C: at the centre
    R: to the right
    J: justified (applicable just on cells)

Syntax for tables is:

    align:A;
    align:A{A-1A-2A-3A-4...};

Explanation: the first character indicates the horizontal alignment of the table 
(as far as l-margin is not set), while the optional string is a string of the form: 
{A-1A-2A-3A-4...} (curly brackets included) where A-1, A-2, A-3, A-4, etc. can be L, C, R or J and
the A-n letter indicates the horizontal alignment for the content of all the cells in the
n-th row. If the number of rows is greater than the length of the optional string, 
the overflowed rows will have default alignment to the left (L).

Example: (table with 10 rows)

    align:R{CCCLLJ};

means that the table is aligned to the right of the document, the content of the 
cells in the first three rows will be aligned at the centre, the content of the
cells in the 4-th and 5-th rows will be aligned to the left and the the content of cells in 
the 6-th row will be aligned to the right, while the rest of the cell contents in the remaining 
rows will be aligned to the left.

Syntax for rows is

    align:{A-1A-2A-3A-4...};

where A-1, A-2,... etc are as in the table case and with the same functionality: 
the A-n character indicates the alignment of the cells in the n-th column that are
in the respective row.

Example:

    align:{LRCCRRLJ}

Syntax for cells is

    align:A;

where A can be L, C, R, J.

Default value: L.

**valign** [C/R/T] 

The property valign defines the vertical alignment of the content of the cells.
The values can be:

    T: top
    M: middle
    B: bottom

Example:

    valign:M; 

Default: T.

Remark: *when using valign property on cell with image property set (see below),
if the cell does not have text, the behaviour of valign is as expected, this is,
the image is positioned accordingly to the value of valign. However, if the cell contains
text, the image and the text are valign-ed in the middle of the cell but 
top (T) or middle (M) valign set the text on top of the image, while valign:B set the text 
under the image.*


**bgcolor** [C/R/T]

The bgcolor property defines the background colour of the cells
The value can be: Hex color code or RGB color code.

Syntax:

    bgcolor:Hex | RGB;

Example:

    bgcolor:#ABCABC;
    bgcolor:#ABC;    
    bgcolor:79,140, 200;

Default: the current fill color set in the document


**font-family** [C/R/T],

It can be either a name defined by the FPDF method AddFont() or 
one of the standard families (case insensitive):

    Courier (fixed-width)
    Helvetica or Arial (synonymous; sans serif)
    Times (serif)
    Symbol (symbolic)
    ZapfDingbats (symbolic)

It is also possible to pass an empty string. In that case, the current family is kept. 

Example:

    font-family:times;

Default: the font-family set in the document.

**font-style** [C/R/T]

Possible values are (case insensitive):

    empty string: regular
    B: bold
    I: italic
    U: underline

or any combination. The default value is regular. Bold and italic styles do not 
apply to Symbol and ZapfDingbats. 

Example:

    font-style:IBU

Default: empty;

**font-size** [C/R/T]

Font size in points.

Example:

    font-size:16;

Default: the current font size of the document.

**font-color** [C/R/T]

This property defines the color of the font for the cells
The value can be: Hex color code or RGB color code.

Syntax:

    font-color:Hex |RGB;

Example:

    font-color:#ABCABC;
    font-color:#ABC;    
    font-color:79,140, 200;

Default value: the current font color set in the document

**line-height** [C/R/T]

The line-height property specifies the line height.

Syntax:

    line-height:number;

Example:

    line-height:1.2;

Default value: 1.

**paddingX** [C/R/T] 

The paddingX property sets the left and right padding (space) of the cells.

Syntax:

    paddingX:mm;

Example:

    paddingX:4;

Default: 0.5.

**paddingY** [C/R/T] 

The paddingY property sets the top and bottom padding (space) of the cells.

Syntax

    paddingY:mm;

Example:

    paddingY:3;

Default: 1.

**colspan** [C]

The colspan attribute defines the number of columns a cell should span.

Syntax:

    colspan:4;

Default 1

**rowspan** [C]
The rowspan attribute defines the number of rows a cell should span.

Syntax:

    rowspan:2;

Default 1

**img** [C]
The img attribute defines the image and its dimensions to be set in the cell.

Syntax:

    img:image.png,w80,h50;
    img:image.png,h50;
    img:image.png;

If no dimensions are specified, the image dimensions are calculate proportionally 
to fit the width of the cell.
If one out of the two dimensions (width or height) is specified but not the other
the one that is not specified is calculated proportionally.
Default value: empty.

# Fonts And UTF8 Support

1. Get the ttf files for the font you want to use and save them in a directory
   Fonts. 
   
   **NOTE:** If you want to use bold, italic or bold-italic font styles you need 
   the respective font files too.

   **NOTE:** the font must contain the characters you want to use
   
2. Using the script makefont.php part of FPDF library (in the makefont directory)

       me@laptop:/path/to/FPDF/makefont$ php makefont.php /path/to/Fonts/My_font.ttf ENCODE

	Note: use the right encode in order to use utf-8 symbols [FPDF: Tutorial 7](http://www.fpdf.org/en/tutorial/tuto7.htm).

   **NOTE:** the font must contain the characters corresponding to the selected encoding.  
   
3. The last command will create the files My_font.php and My_font.z in 
   the directory /path/to/FPDF/makefont move those file to the directory 
   /path/to/FPDF/font
   
4. You are ready to use your fonts in your script:

       $pdf = new PDF();
       $pdf->AddFont('Cool-font','','My_font.php');  // Define the new font to use in the PDF object
       
       // more code
       
       $table=new easyTable($pdf, ...);
       $table->easyCell(iconv("UTF-8", "ENCODE",'Hello World'), 'font-color:#66686b;font-family:Cool-font');
       //etc...

5. [Example](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.pdf): 
   we get a ttf font file (my_font.ttf) that support the language and symbols we want to use.
   For this example we are using Russian. The encode that we are using for Russian is KOI8-R

       php makefont.php /path/to/font_ttf/my_font.ttf KOI8-R
   
   then we copy the resulting files to the font directory of FPDF library. 
   
   Then, in our script:

       $pdf = new PDF();
 
       $pdf->AddFont('FontUTF8','','my_font.php'); 
  
       $pdf->SetFont('FontUTF8','',8); // set default font for the document 

       $table=new easyTable($pdf, ...);
	
       $Table->easyCell(iconv("UTF-8", "KOI8-R", "дебет дефинитионес цу")); // Notice the encode KOI8-R

   or
   
       $pdf = new PDF();
       $pdf->AddPage();
       $pdf->SetFont('Arial','B',16);
       
       $pdf->AddFont('FontUTF8','','my_font.php'); 
  
       $table=new easyTable($pdf, 5, '...');	
       $Table->easyCell(iconv("UTF-8", "KOI8-R", "дебет дефинитионес цу"), 'font-family:FontUTF8;'); 
       

   NOTE: For more about the right encode visit [FPDF: Tutorial 7](http://www.fpdf.org/en/tutorial/tuto7.htm)
   and [php inconv](http://php.net/manual/en/function.iconv.php)
   
# Using with FPDI

If your project requieres easyTable and [FPDI](https://www.setasign.com/products/fpdi/about/), this is
how you should do it. Assuming that fpdf.php, easyTable.php, exfpdf.php, fpdi.php and any 
other files from this libraries are in the same directory. 

The class exfpdf should extends the class fpdi instead of the class fpdf. So in exfpdf.php:

    <?php

    class exFPDF extends FPDI
    {
    etc
    etc

And in your project:

    <?php
    include 'fpdf.php';
    include 'fpdi.php';
    include 'exfpdf.php';
    include 'easyTable.php';

    //$pdf = new FPDI(); remember exfpdf is extending the fpdi class
    $pdf=new exFPDF(); // so we initiate exFPDF instead of FPDI

    // add a page
    $pdf->AddPage();
    // set the source file
    $pdf->setSourceFile("example-2.pdf");
    // import page 1
    $tplIdx = $pdf->importPage(1);
    // use the imported page and place it at point 10,10 with a width of 100 mm
    $pdf->useTemplate($tplIdx, 10, 10, 100);

    //add another page
    $pdf->AddPage();
    $pdf->SetFont('helvetica','',10);

    $table1=new easyTable($pdf, 2);
    $table1->easyCell('Sales Invoice', 'font-size:30; font-style:B; font-color:#00bfff;');
    $table1->easyCell('', 'img:fpdf.png, w80; align:R;');
    $table1->printRow();
    //etc
    //etc
    
# Tag Based Font Style

The new version of FPDF EasyTable can handle tag-based font styles at string level.

    $table->easyCell('Project: EasyTable', 'font-family:lato; font-size:30; font-color:#00bfff;');

now we can do:

    $table->easyCell('<b>Project:</b> <s "font-size:20; font-family:times">EasyTable</s>', 'font-family:lato; font-size:30; font-color:#00bfff;');

The font style set at the string level will over write any other font style set at the cell, row or table level.

Please see the [example](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.pdf)
  * [Code](https://github.com/fpdf-easytable/fpdf-easytable/blob/master/basic_example.php)

Tags

**<s "fontstyle"></s>**

font-style is a semicolon separated string which can include: font-size, font-family, font-style, font-color, href;

   Note: Remember to define every font your project needs.

    $pdf->AddFont('MyFabFont','','my_font.php');   
    $pdf->AddFont('MyFabFont','B','my_font_bold.php');   
    $pdf->AddFont('MyFabFont','I','my_font_italic.php');   
    $pdf->AddFont('MyFabFont','BI','my_font_bolditalic.php');   

font-color can be Hex color code or RGB color code.

**Shortcuts** 

    <b></b> is equalt to: <s "font-style:B"></s>
    <i></i> is equalt to: <s "font-style:I"></s>

**Tags can be nested**

When nested tags are used, the result is similar to the case in HTML documents.

    <b>Helo <i>world</i></b>

     <s "font-style:I; font-color#abc123; font-family:times">Hello  <s "font-style:B; font-family:lato; font-size:20">world</s></s>

- Different font style can be applied to the letters of a word.

````
	<b>H<i>e</i><s "font-family:myfont">ll<s "font-size">o</s></s></b> 
````

**Links**

Use the property 'href' to set links

    <b>Helo <s "font-family:my_fab_font; font-color:#AABBCC; href:http://www.example.com">world</s></b>


**Escape sequence**

The sequence '\\<s' is parced as '<s'

    <b>Helo <s "font-family:my_fab_font;">\<sammy@example.com></s></b>

# Common Error

A very typical situation is: *"EasyTable works in my localhost but it does not
work in remote server"*... Seriously, what on earth it has to do with EasyTable?... And the error
reported is 
    Fatal error: Uncaught exception 'Exception' with message 'FPDF error: Some data has 
    already been output, can't send PDF file... etc etc...

It is because when the server hit the script to output a PDF document, it already set 
the headers as PDF document, however somewhere/how (trigger by an configuration error of your server) 
is outputting html/txt data.
 
One very common error is to forget to add the fonts and its different style (I, B, IB) used in the document. 
Let's suppose that in your document you use "my_favourite_font". Then you need to add 

    $pdf->AddFont('MyFabFont','','my_favourite_font.php'); 
    
if you are using the bold version of it, then you must add:      

    $pdf->AddFont('MyFabFont','B','my_favourite_font_bold.php');   

if you are using the italic version, then you need to add:

    $pdf->AddFont('MyFabFont','I','my_favourite_font_italic.php');   

if you are using the bold-italic, then

    $pdf->AddFont('MyFabFont','BI','my_favourite_font_bolditalic.php');

You need to generate each of the font files that needs to be added in your project
('my_favourite_font_bold.php', 'my_favourite_font_italic.php', 'my_favourite_font_bolditalic.php'),
refer to your font documentation and see [Fonts And UTF8 Support](https://github.com/fpdf-easytable/fpdf-easytable#fonts-and-utf8-support).

# Get In Touch

Your comments and questions are welcome: easytable@yandex.com (with the subject: EasyTable)

# Other projects

- [Simple Unit Test](https://github.com/fpdf-easytable/simple_unit_test) PHP unit test as it should be.
- [SimpleCharts.js](https://github.com/fpdf-easytable/simpleCharts.js)
- [Ajax Server Response Hander](https://github.com/fpdf-easytable/ajax_server_response_hander) Simplify server response from ajax calls
- [Crypt](https://github.com/fpdf-easytable/Crypt)

# Donations

Any monetary contribution would be appreciated :-)

If you are using this for the company you work for, they are getting the money, you are getting 
the medals and I am getting nothing! Is that fair?

It does cost NOTHING to push the freaky star button!!

[![Donate](https://www.paypalobjects.com/en_US/GB/i/btn/btn_donateCC_LG.gif)](https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=JALWQVBS2KGQC)


# License

This is free and unencumbered software released into the public domain.

Anyone is free to copy, modify, publish, use, compile, sell, or
distribute this software, either in source code form or as a compiled
binary, for any purpose, commercial or non-commercial, and by any
means.

In jurisdictions that recognize copyright laws, the author or authors
of this software dedicate any and all copyright interest in the
software to the public domain. We make this dedication for the benefit
of the public at large and to the detriment of our heirs and
successors. We intend this dedication to be an overt act of
relinquishment in perpetuity of all present and future rights to this
software under copyright law.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
IN NO EVENT SHALL THE AUTHORS BE LIABLE FOR ANY CLAIM, DAMAGES OR
OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE,
ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

For more information, please refer to <http://unlicense.org/>



