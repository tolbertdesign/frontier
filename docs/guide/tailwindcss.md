---
title: Tailwind CSS
description: A utility-first CSS framework for **rapidly building custom designs.**
---
 
Tailwind CSS is a highly customizable, low-level CSS framework that gives you all of the building blocks you need to build bespoke designs without any annoying opinionated styles you have to fight to override.

## Why Tailwind

Most CSS frameworks do too much.

They come with all sorts of predesigned components like buttons, cards, and alerts that might help you move quickly at first, but cause more pain than they cure when it comes time to **make your site stand out with a custom design**.

Tailwind is different.

Instead of opinionated predesigned components, Tailwind provides low-level utility classes that let you build completely custom designs without ever leaving your HTML.

## Tailwind core plugins

| Core Plugin                | Description                                                   |
| -------------------------- | ------------------------------------------------------------- |
| `preflight`                | Tailwind's base/reset styles                                  |
| `container`                | The `container` component                                     |
| `accessibility`            | The `sr-only` and not-sr-only utilities                       |
| `alignContent`             | The `align-content` utilities like `content-between`          |
| `alignItems`               | The `align-items` utilities like `items-start`                |
| `alignSelf`                | The `align-self` utilities like `self-end`                    |
| `appearance`               | The `appearance` utilities like `appearance-none`             |
| `backgroundAttachment`     | The `background-attachment` utilities like `bg-fixed`         |
| `backgroundColor`          | The `background-color` utilities like `bg-gray-200`           |
| `backgroundPosition`       | The `background-position` utilities like `bg-center`          |
| `backgroundRepeat`         | The `background-repeat` utilities like `bg-no-repeat`         |
| `backgroundSize`           | The `background-size` utilities like `bg-cover`               |
| `borderCollapse`           | The `border-collapse` utilities like `border-separate`        |
| `borderColor`              | The `border-color` utilities like `border-gray-300`           |
| `borderRadius`             | The `border-radius` utilities like `rounded-lg`               |
| `borderStyle`              | The `border-style` utilities like `border-dashed`             |
| `borderWidth`              | The `border-width` utilities like `border-2`                  |
| `boxSizing`                | The `box-sizing` utilities like `box-border`                  |
| `boxShadow`                | The `box-shadow` utilities like `shadow-xl`                   |
| `clear`                    | The `clear` utilities like `clear-left`                       |
| `cursor`                   | The `cursor` utilities like `cursor-pointer`                  |
| `display`                  | The `display` utilities like `block`                          |
| `fill`                     | The `fill` utilities like `fill-current`                      |
| `flex`                     | The `flex` utilities like `flex-1`                            |
| `flexDirection`            | The `flex-direction` utilities like `flex-col`                |
| `flexGrow`                 | The `flex-grow` utilities like `flex-grow-0`                  |
| `flexShrink`               | The `flex-shrink` utilities like `flex-shrink-0`              |
| `flexWrap`                 | The `flex-wrap` utilities like `flex-no-wrap`                 |
| `float`                    | The `float` utilities like `float-left`                       |
| `gap`                      | The `gap` utilities like `gap-4`                              |
| `gridAutoFlow`             | The `grid-auto-flow` utilities like `grid-flow-col`           |
| `gridColumn`               | The `grid-column` utilities like `col-span-6`                 |
| `gridColumnStart`          | The `grid-column-start` utilities like `col-start-1`          |
| `gridColumnEnd`            | The `grid-column-end` utilities like `col-end-4`              |
| `gridRow`                  | The `grid-row` utilities like `row-span-6`                    |
| `gridRowStart`             | The `grid-row-start` utilities like `row-start-1`             |
| `gridRowEnd`               | The `grid-row-end` utilities like `row-end-4`                 |
| `gridTemplateColumns`      | The `grid-template-columns` utilities like `grid-cols-4`      |
| `gridTemplateRows`         | The `grid-template-rows` utilities like `grid-rows-4`         |
| `fontFamily`               | The `font-family` utilities like `font-sans`                  |
| `fontSize`                 | The `font-size` utilities like `text-xl`                      |
| `fontSmoothing`            | The `font-smoothing` utilities like `antialiased`             |
| `fontStyle`                | The `font-style` utilities like `italic`                      |
| `fontWeight`               | The `font-weight` utilities like `font-bold`                  |
| `height`                   | The `height` utilities like `h-8`                             |
| `inset`                    | The `inset` utilities like `top-0`                            |
| `justifyContent`           | The `justify-content` utilities like `justify-between`        |
| `letterSpacing`            | The `letter-spacing` utilities like `tracking-tight`          |
| `lineHeight`               | The `line-height` utilities like `leading-normal`             |
| `listStylePosition`        | The `list-style-position` utilities like `list-inside`        |
| `listStyleType`            | The `list-style-type` utilities like `list-disc`              |
| `margin`                   | The `margin` utilities like `mt-4`                            |
| `maxHeight`                | The `max-height` utilities like `max-h-screen`                |
| `maxWidth`                 | The `max-width` utilities like `max-w-full`                   |
| `minHeight`                | The `min-height` utilities like `min-h-screen`                |
| `minWidth`                 | The `min-width` utilities like `min-w-0`                      |
| `objectFit`                | The `object-fit` utilities like `object-cover`                |
| `objectPosition`           | The `object-position` utilities like `object-center`          |
| `opacity`                  | The `opacity` utilities like `opacity-50`                     |
| `order`                    | The `flexbox` order utilities like `order-last`               |
| `outline`                  | The `outline` utilities like `outline-none`                   |
| `overflow`                 | The `overflow` utilities like `overflow-hidden`               |
| `padding`                  | The `padding` utilities like `py-12`                          |
| `pointerEvents`            | The `pointer-events` utilities like `pointer-events-none`     |
| `position`                 | The `position` utilities like `absolute`                      |
| `resize`                   | The `resize` utilities like `resize-y`                        |
| `rotate`                   | The `rotate` utilities like `rotate-90`                       |
| `scale`                    | The `scale` utilities like `scale-150`                        |
| `skew`                     | The `skew` utilities like `skew-y-3`                          |
| `stroke`                   | The `stroke` utilities like `stroke-current`                  |
| `strokeWidth`              | The `stroke-width` utilities like `stroke-2`                  |
| `tableLayout`              | The `table-layout` utilities like `table-fixed`               |
| `textAlign`                | The `text-align` utilities like `text-center`                 |
| `textColor`                | The `text-color` utilities like `text-red-600`                |
| `textDecoration`           | The `text-decoration` utilities like `underline`              |
| `textTransform`            | The `text-transform` utilities like `uppercase`               |
| `transform`                | The `transform` utility (for enabling transform features)     |
| `transitionDuration`       | The `transition-duration` utilities like `duration-100`       |
| `transitionProperty`       | The `transition-property` utilities like `transition-colors`  |
| `transitionTimingFunction` | The `transition-timing-function` utilities like `ease-in-out` |
| `translate`                | The `translate` utilities like `translate-y-6`                |
| `userSelect`               | The `user-select` utilities like `user-select-none`           |
| `verticalAlign`            | The `vertical-align` utilities like `align-middle`            |
| `visibility`               | The `visibility` utilities like `invisible`                   |
| `whitespace`               | The `whitespace` utilities like `whitespace-no-wrap`          |
| `width`                    | The `width` utilities like `w-1`/2                            |
| `wordBreak`                | The `word-break` utilities like `break-all`                   |
| `zIndex`                   | The `z-index` utilities like `z-50`                           |

## Example configuration scenarios

- Default
- Only whitelisted
- Disable some
- Expose the defaults

## Referencing in JavaScript

```js
import resolveConfig from 'tailwindcss/resolveConfig'
import tailwindConfig from './tailwind.config.js'

const fullConfig = resolveConfig(tailwindConfig)

fullConfig.theme.width[4]
// => '1rem'

fullConfig.theme.screens.md
// => '768px'

fullConfig.theme.boxShadow['2xl']
// => '0 25px 50px -12px rgba(0, 0, 0, 0.25)'
```
