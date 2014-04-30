import fontforge
from glob import glob

svg_fonts = glob("*.svg")

print svg_fonts

# font = fontforge.open()