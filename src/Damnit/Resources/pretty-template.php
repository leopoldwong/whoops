<?php
/**
* Template file for Damnit's pretty error output.
* Check the $v global variable (stdClass) for what's available
* to work with.
* @var $v
*/
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Damn it! - There was an error.</title>

    <style>
      .cf:before,
      .cf:after {content: " "; /* 1 */
                 display: table; /* 2 */}
      .cf:after {clear: both;}
      .cf {*zoom: 1;}
      body {
        font: 14px helvetica, arial, sans-serif;
        color: #2B2B2B;
        background-color: #DADADA;

        padding:0;
        margin: 0;
      }

      .branding {
        position: absolute;
        top: 10px;
        right: 20px;
        color: #777777;
        font-size: 10px;
      }
        .branding a {
          color: #CD3F3F;
        }

      header {
        padding: 30px 20px;
        color: white;
        background: #272727;
      }

      .exc-title {
        margin: 0;
        color: #616161;

        text-shadow: 0 1px 2px rgba(0, 0, 0, .1);
      }
        .exc-title-primary { color: #CD3F3F; }

      .exc-message {
        font-size: 32px;
        margin: 5px 0;
      }

      .frames-container {
        float: left;
        width: 30%;
      }

      .details-container {
        float: right;
        width: 70%;
      }
        .details {
          margin: 10px;
        }

      .frame {
        padding: 14px;
        background: #F3F3F3;
        border-right: 1px solid rgba(0, 0, 0, .2);
        cursor: pointer;
      }
        .frame.active {
          background-color: #4288CE;
          color: #F3F3F3;
        }

        .frame:not(.active):hover {
          background: #BEE9EA;
        }

        .frame-file {
          font-family: consolas, monospace;
          word-wrap:break-word;
        }
          .frame-line {
            font-weight: bold;
            color: #4288CE;
          }
            .active .frame-line { color: #BEE9EA; }
          .frame-line:before {
            content: ":";
          }

      .frame-code {
        padding: 10px;
        padding-left: 5px;
        background: #BDBDBD;
        display: none;
        border-left: 5px solid #4288CE;
      }
        .frame-code.active {
          display: block;
        }

        .frame-code .frame-file {
          background: #C6C6C6;
          color: #525252;
          text-shadow: 0 1px 0 #E7E7E7;
          padding: 10px 10px 5px 10px;

          border-top-right-radius: 6px;
          border-top-left-radius:  6px;

          border: 1px solid rgba(0, 0, 0, .1);
          border-bottom: none;
          box-shadow: inset 0 1px 0 #DADADA;
        }

      .code-block {
        padding: 10px;
        margin: 0;
        box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);

        border-bottom-right-radius: 2px;
        border-bottom-left-radius: 2px;
      }
        .linenums {
          margin: 0;
        }

      .data-table-container label {
        font-size: 16px;
        font-weight: bold;
        color: #4288CE;
        margin: 10px 0;
        padding: 10px 0;

        display: block;
        margin-bottom: 5px;
        padding-bottom: 5px;
        border-bottom: 1px dotted rgba(0, 0, 0, .2);
      }
        .data-table {
          margin: 10px 0;

          font: 13px consolas, monospace;
        }
          .data-table thead {
            display: none;
          }

        .data-table tr {
          padding: 5px 0;
        }
          .data-table td:first-child {
            width: 15%;
            min-width: 130px;
            overflow: hidden;
            font-weight: bold;

            color: #463C54;
            padding-right: 5px;
          }

          .data-table td:last-child {
            width: 80%;
            white-space: pre-wrap;
          }

        .handler {
          padding: 10px;
          font: 14px monospace;
        }
          .handler.active {
            color: #BBBBBB;
            background: #989898;
            font-weight: bold;
          }

      /* prettify code style
       Uses the Doxy theme as a base */
      pre .str, code .str { color: #79E3E1; }  /* string  */
      pre .kwd, code .kwd { color: #FDFF62;  font-weight: bold; }  /* keyword*/
      pre .com, code .com { color: #A5A5A5; font-weight: bold; } /* comment */
      pre .typ, code .typ { color: #E16CA1; }  /* type  */
      pre .lit, code .lit { color: #49DF9D; }  /* literal */
      pre .pun, code .pun { color: #51D743; font-weight: bold;  } /* punctuation  */
      pre .pln, code .pln { color: #BBBBBB; }  /* plaintext  */
      pre .tag, code .tag { color: #9c9cff; }  /* html/xml tag  */
      pre .htm, code .htm { color: #dda0dd; }  /* html tag */
      pre .xsl, code .xsl { color: #d0a0d0; }  /* xslt tag */
      pre .atn, code .atn { color: #46eeee; font-weight: normal;} /* html/xml attribute name */
      pre .atv, code .atv { color: #EEB4B4; }  /* html/xml attribute value  */
      pre .dec, code .dec { color: #3387CC; }  /* decimal  */

      a {
        text-decoration: none;
      }
      pre.prettyprint, code.prettyprint {
        font-family: consolas, monospace;
        background: #272727;
        color: #929292;
      }

      pre.prettyprint {
        white-space: pre-wrap;
      }

      pre.prettyprint a, code.prettyprint a {
         text-decoration:none;
      }
    </style>
  </head>
  <body>
    <div class="container">
      <div class="branding">
        generated by the <strong><a href="http://github.com/filp/damnit">damnit!</a></strong> php error handler
      </div>
      <header>
        <div class="exception">
          <h3 class="exc-title">
            <?php foreach($v->name as $i => $nameSection): ?>
              <?php if($i == count($v->name) - 1): ?>
                <span class="exc-title-primary"><?php echo $e($nameSection) ?></span>
              <?php else: ?>
                <?php echo $e($nameSection) . '\\' ?>
              <?php endif ?>
            <?php endforeach ?>
          </h3>
          <p class="exc-message">
            <?php echo $e($v->message) ?>
          </p>
        </div>
      </header>
      <div class="stack-container">

        <div class="frames-container cf <?php echo (!$v->hasFrames ? 'empty' : '') ?>">

          <?php /* List file names & line numbers for all stack frames;
                   clicking these links/buttons will display the code view
                   for that particular frame */ ?>
          <?php foreach($v->frames as $i => $frame): ?>
            <div class="frame <?php echo ($i == 0 ? 'active' : '') ?>" id="frame-line-<?php echo $i ?>">
              <span class="frame-file">
                <?php echo $e($frame->getFile()) ?><!-- get rid of ugly whitespace
                --><span class="frame-line"><?php echo (int) $frame->getLine() ?></span>
              </span>
            </div>
          <?php endforeach ?>

        </div>

        <div class="details-container cf">

          <?php /* Display a code block for all frames in the stack.
                 * @todo: This should PROBABLY be done on-demand, lest
                 * we get 200 frames to process. */ ?>
          <div class="frame-code-container <?php echo (!$v->hasFrames ? 'empty' : '') ?>">
            <?php foreach($v->frames as $i => $frame): ?>

              <?php $line = $frame->getLine(); ?>
              <?php if($line !== null): ?>
                <div class="frame-code <?php echo ($i == 0 ) ? 'active' : '' ?>" id="frame-code-<?php echo $i ?>">
                  <?php
                    // the $line is 1-indexed, we nab -1 where needed to account for this
                    $range = $frame->getFileLines($line - 3, 4);
                    $start = key($range) + 1;
                    $code  = join("\n", $range);
                  ?>

                  <div class="frame-file">
                    <strong><?php echo $e($frame->getFile()) ?></strong>
                  </div>
                  <pre class="code-block prettyprint linenums:<?php echo $start ?>"><?php echo $e($code) ?></pre>
                </div>
              <?php endif ?>
            <?php endforeach ?>
          </div>

          <?php /* List superglobal values, i.e: $_SERVER, $_GET, .... */ ?>
          <div class="details">
            <div class="data-table-container" id="superglobals">
              <?php foreach($v->super as $label => $data): ?>
                <?php if(!empty($data)): ?>

                  <div class="superglobal" id="sg-<?php echo $e($slug($label)) ?>">
                    <label><?php echo $e($label) ?></label>

                    <table class="data-table">
                      <thead>
                        <tr>
                          <td class="superglobal-k">Key</td>
                          <td class="superglobal-v">Value</td>
                        </tr>
                      </thead>
                    <?php foreach($data as $k => $value): ?>
                    <tr>
                      <td><?php echo $e($k) ?></td>
                      <td><?php echo $e(print_r($value, true)) ?></td>
                    </tr>
                    <?php endforeach ?>
                    </table>

                  </div>

                <?php endif ?>
              <?php endforeach ?>
            </div>

            <?php /* List registered handlers, in order of first to last registered */ ?>
            <div class="data-table-container" id="handlers">
              <label>Registered Handlers</label>
              <?php $handlersCount = count($v->handlers) - 1; ?>
              <?php for($i = $handlersCount; $i >= 0; $i--): ?>
                <?php $handler = $v->handlers[$i]; ?>
                <div class="handler <?php echo ($handler == $v->handler) ? 'active' : ''?>">
                  <?php echo  $handlersCount - $i?>. <?php echo $e(get_class($handler)) ?>
                </div>
              <?php endfor ?>
            </div>

          </div> <!-- .details -->
        </div>

      </div>
    </div>

    <script src="http://cdnjs.cloudflare.com/ajax/libs/prettify/r224/prettify.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script>
      $(function() {
        prettyPrint();

        var $frameLines  = $('[id^="frame-line-"]');
        var $activeLine  = $('.frames-container .active');
        var $activeFrame = $('.active[id^="frame-code-"]').show();

        $frameLines.click(function() {
          var $this  = $(this);
          var id     = /frame\-line\-([\d]*)/.exec($this.attr('id'))[1];
          var $codeFrame = $('#frame-code-' + id);

          if($codeFrame) {
            $activeLine.removeClass('active');
            $activeFrame.removeClass('active');

            $this.addClass('active');
            $codeFrame.addClass('active');

            $activeLine  = $this;
            $activeFrame = $codeFrame;
          }
        });
      });
    </script>
  </body>
</html>
